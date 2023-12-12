CREATE TABLE IF NOT EXISTS temp_processed_attendances (
    emp_id INT,
    emp_card_id VARCHAR(255) NULL,
    employee_type_id BIGINT UNSIGNED NULL,
    department_id BIGINT UNSIGNED NULL,
    section_id BIGINT UNSIGNED NULL,
    sub_section_id BIGINT UNSIGNED NULL,
    designation_id BIGINT UNSIGNED NULL,
    shift_id BIGINT UNSIGNED NULL,
    unit_id BIGINT UNSIGNED NULL,
    floor_id BIGINT UNSIGNED NULL,
    line_id BIGINT UNSIGNED NULL,
    punch_date DATETIME,
    time_in TIME,
    time_out TIME,
    late TIME,
    ot_hour TIME,
    remarks TEXT NULL,
    status VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS temp_time_process (
    emp_id INT,
    time_in_out TIME,
);

CREATE TABLE IF NOT EXISTS temp_late_ot (
    emp_id INT,
    time_late_ot TIME,
);

DELIMITER //

CREATE PROCEDURE attendance_processed(IN input_date DATE)
BEGIN
    DECLARE @Date DATE;
    SET @Date = '2023-08-30';
    SET @department_id = 1;

    Truncate table temp_processed_attendances; 
	     
    INSERT INTO temp_processed_attendances (emp_id, emp_card_id, employee_type_id, department_id, section_id, sub_section_id, designation_id, shift_id, unit_id, floor_id, line_id, punch_date, time_in, time_out, late, ot_hour, remarks, status)
    SELECT id,emp_code,employee_type_id,department_id,section_id,sub_section_id,designation_id,shift_id,unit_id,floor_id,line_id,@Date,null,null,'00:00','00:00',line_id,'a'
    FROM employees
    WHERE is_active=1
    AND department_id = @department_id;         


    UPDATE temp_processed_attendances p
    JOIN employee_shift_entries s ON p.emp_id = s.employee_id AND p.punch_date = s.date
    SET p.shift_id = s.shift_id;

    DELETE p
    FROM processed_attendances p
    JOIN temp_processed_attendances temp ON p.emp_id = temp.emp_id and p.punch_date = @Date;
    
    UPDATE temp_processed_attendances P
    SET P.status = (
        SELECT 'h'
        FROM holidays
        WHERE holidays.date = @Date
        LIMIT 1
    )
    WHERE P.punch_date = @Date;

	UPDATE temp_processed_attendances P
	SET P.status = 'w'
	WHERE P.punch_date = @Date
	AND DAYOFWEEK(@Date) = 6;

    -- for in time get 5
    Truncate table temp_time_process; 

    -- old insert in time
  --  Insert into temp_time_process(emp_id,time_in_out)  
  --  Select emp_id,Min(punch_time) from attendance_rows
  --  where punch_date = @Date
  --      and emp_id in (Select tp.emp_id from temp_processed_attendances tp JOIN shifts s Where tp.punch_date = @Date and s.id = tp.shift_id 
        -- and Convert(Varchar,s.time_in,108) Between s.time_in and s.shift_out
  --      )
  --  Group by emp_id;

    Insert into temp_time_process(emp_id,time_in_out) 
    SELECT  ra.emp_id, Min(ra.punch_time)
    FROM attendance_rows ra
    LEFT JOIN shifts s ON s.id = (Select shift_id from temp_processed_attendances WHERE shift_id= ra.shift_id AND emp_id=ra.emp_id)
    WHERE ra.punch_date = @DATE
    AND TIME(ra.punch_time) >= TIMESTAMPADD(HOUR, -2, TIME(s.shift_in))
        and emp_id in (Select tp.emp_id from temp_processed_attendances tp JOIN shifts s Where tp.punch_date = @Date and s.id = tp.shift_id 
            -- and Convert(Varchar,s.time_in,108) Between s.time_in and s.shift_out
            )
    GROUP BY ra.emp_id;



    UPDATE temp_processed_attendances P
    JOIN temp_time_process T ON P.emp_id = T.emp_id AND P.punch_date = @Date
    Set P.time_in = T.time_in_out , P.status = 'p';

    -- for out time get 
    Truncate table temp_time_process; 

    -- Insert into temp_time_process(emp_id,time_in_out)  
    -- Select emp_id,Max(punch_time) from attendance_rows
    -- where punch_date = @Date
    --     and emp_id in (Select p.emp_id from temp_processed_attendances p JOIN shifts s Where p.punch_date = @Date and s.id = p.shift_id 
    --     -- and Convert(Varchar,s.time_in,108) Between s.time_in and s.shift_out
    --     -- and Convert(Varchar,s.time_in,108) Between '05:00' and '16:00'
    --     )
    -- Group by emp_id;

	Insert into temp_time_process(emp_id,time_in_out) 
	SELECT  ra.emp_id, MAX(ra.punch_time)
    FROM attendance_rows ra
    LEFT JOIN shifts s ON s.id = (Select shift_id from temp_processed_attendances WHERE shift_id= ra.shift_id AND emp_id=ra.emp_id)
    WHERE 
        (
	        (TIME(s.shift_out) >= '05:00:00' AND TIME(s.shift_out) <= '10:00:00' AND (SELECT TIME(time_in) FROM temp_processed_attendances WHERE emp_id = ra.emp_id) >= '17:00:00' AND (SELECT TIME(time_in) FROM temp_processed_attendances WHERE emp_id = ra.emp_id) <= '12:00:00' AND ra.punch_date = DATE_ADD(@Date, INTERVAL 1 DAY))
	        OR
	        (ra.punch_date = @Date)
	     )
    AND TIME(ra.punch_time) <= TIMESTAMPADD(HOUR, +2, TIME(s.shift_out)) AND TIME(ra.punch_time) > (SELECT TIME(time_in) FROM temp_processed_attendances WHERE emp_id = ra.emp_id)
         and emp_id in (Select tp.emp_id from temp_processed_attendances tp JOIN shifts s Where tp.punch_date = @Date and s.id = tp.shift_id 
            -- and Convert(Varchar,s.time_in,108) Between s.time_in and s.shift_out
            )
    GROUP BY ra.emp_id;


    UPDATE temp_processed_attendances P
    JOIN temp_time_process T ON P.emp_id = T.emp_id AND P.punch_date = @Date
    Set P.time_out = T.time_in_out;


    -- calculate late hour
    Truncate table temp_late_ot;

	INSERT INTO temp_late_ot (emp_id, time_late_ot)
	SELECT p.emp_id,
			TIME_FORMAT(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CAST(s.shift_late AS TIME), p.time_in)), '%H:%i:%s') AS time_difference_formatted
	FROM temp_processed_attendances p
	JOIN shifts s ON p.punch_date = @Date AND p.time_in > CAST(s.shift_late AS TIME);
	
   
   UPDATE temp_processed_attendances P
   JOIN temp_late_ot T ON P.emp_id = T.emp_id and T.time_late_ot > 0 AND P.punch_date = @Date
   Set P.late = T.time_late_ot , P.status = 'l';

    -- calculate overtime hour
   Truncate table temp_late_ot;

	
	INSERT INTO temp_late_ot (emp_id, time_late_ot)
	SELECT p.emp_id, 
	       TIME_FORMAT(SEC_TO_TIME(TIMESTAMPDIFF(SECOND, CAST(s.shift_out AS TIME), p.time_out)), '%H:%i:%s') AS time_difference_formatted
	FROM temp_processed_attendances p
	JOIN shifts s ON p.punch_date = @Date AND p.time_out > CAST(s.shift_out AS TIME);

    
   UPDATE temp_processed_attendances P
   JOIN temp_late_ot T ON P.emp_id = T.emp_id and T.time_late_ot > 0 and P.punch_date = @Date
   Set P.ot_hour = T.time_late_ot;

    -- Update temp_processed_attendances
    -- set status='p'
    -- where time_in not null;

    -- Update temp_processed_attendances
    -- set status='a'
    -- where time_in is null and status is null;

    -- temp_processed_attendances with fix fix_attendances table

   UPDATE temp_processed_attendances P
   JOIN fix_attendances A ON P.emp_id = A.emp_id and P.punch_date = A.punch_date and A.time_in IS NOT NULL and P.punch_date = @Date
   Set P.time_in = A.time_in;

   UPDATE temp_processed_attendances P
   JOIN fix_attendances A ON P.emp_id = A.emp_id and P.punch_date = A.punch_date and A.time_out IS NOT NULL and P.punch_date = @Date
   Set P.time_out = A.time_out;
   
   UPDATE temp_processed_attendances P
   JOIN fix_attendances A ON P.emp_id = A.emp_id and P.punch_date = A.punch_date and A.late > '00:00' and P.status = A.status and P.punch_date = @Date
   Set P.late = A.late;

   UPDATE temp_processed_attendances P
   JOIN fix_attendances A ON P.emp_id = A.emp_id and P.punch_date = A.punch_date and A.ot_hour > '00:00' and P.status = A.status and P.punch_date = @Date
   Set P.ot_hour = A.ot_hour;

   UPDATE temp_processed_attendances P
   JOIN fix_attendances A ON P.emp_id = A.emp_id and P.punch_date = A.punch_date and P.status = A.status and P.punch_date = @Date
   Set P.status = A.status;   

   UPDATE fix_attendances
	SET action = 1
	WHERE action = 0 AND punch_date = @Date;
	
    -- check for leave entris
	UPDATE temp_processed_attendances P
	JOIN leave_entries le ON P.emp_id = le.emp_id AND P.punch_date = @Date AND le.from_date >= @Date AND le.to_date <= @Date
	JOIN leave_types lt ON lt.id = le.leave_type_id
	SET P.status = LOWER(lt.short_name);
	

    UPDATE temp_processed_attendances P
    SET P.status = 'a'
    WHERE P.status IS NULL AND P.punch_date = @Date;

    UPDATE temp_processed_attendances P
    SET P.status = 'l'
    WHERE P.late>'00:00:00' AND P.punch_date = @Date;

    -- Update temp_processed_attendances
    -- set late='00:00'
    -- where status in ('w','h') and punch_date=@Date;

    -- insert processed_attendances from temp_processed_attendances
    Insert Into processed_attendances (emp_id, emp_card_id, employee_type_id, department_id, section_id, sub_section_id, designation_id, shift_id, unit_id, floor_id, line_id, punch_date, time_in, time_out, late, ot_hour, remarks, status)
    SELECT  emp_id, emp_card_id, employee_type_id, department_id, section_id, sub_section_id, designation_id, shift_id, unit_id, floor_id, line_id, punch_date, time_in, time_out, late, ot_hour, remarks, status
    FROM temp_processed_attendances;

    Update processed_attendances
    set late = '00:00'
    where status in ('w','h') and punch_date = @Date;

    Update processed_attendances
    Set time_in = null,time_out = null,late = '00:00',ot_hour = '00:00'
    Where Status in ('a','cl','el','ml','sl','others') and punch_date = @Date;
    
   Truncate table temp_processed_attendances;
   Truncate table temp_time_process;
   Truncate table temp_late_ot;
   

END //

DELIMITER ;




