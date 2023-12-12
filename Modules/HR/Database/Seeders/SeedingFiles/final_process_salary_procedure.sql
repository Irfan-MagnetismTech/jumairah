BEGIN

    Truncate table temp_processed_salaries;

    INSERT INTO temp_processed_salaries(emp_id,employee_type_id, department_id, section_id, shift_id, designation_id, month, total_working_day, total_working_amount, total_late_hour, total_late_amount, total_ot_hour, total_ot_amount, adjustment_amount,com_id)
    SELECT id,employee_type_id,department_id,section_id,shift_id,designation_id,@month,null,null,null,null,null,NULL,NULL,@Com_User
    FROM employees
    WHERE is_active=1
    AND department_id = @Department;

    DELETE p
    FROM processed_salaries p
    JOIN temp_processed_salaries temp ON p.emp_id = temp.emp_id and
    MONTH(CONCAT(p.month, '-01')) = MONTH(CONCAT(@month, '-01'));

    UPDATE temp_processed_salaries ps
    JOIN processed_attendances pa ON ps.emp_id = ps.emp_id AND month(pa.punch_date) = MONTH(CONCAT(@month, '-01'))
    AND pa.department_id = @Department
    SET ps.total_working_day= (SELECT COUNT(*) AS count_of_days
    FROM processed_attendances
    WHERE status in ('p','l','w','h') AND emp_id = ps.emp_id AND MONTH(pa.punch_date) = MONTH(CONCAT(@month, '-01')));

    -- calculate total_working_day
    UPDATE temp_processed_salaries ps
    JOIN processed_attendances pa ON ps.emp_id = pa.emp_id
        AND MONTH(pa.punch_date) = MONTH(CONCAT(@month, '-01'))
        AND pa.department_id = @Department
    SET ps.total_working_day = (
        SELECT COUNT(*) AS count_of_days
        FROM processed_attendances
        WHERE status IN ('p', 'l', 'w', 'h') AND emp_id = ps.emp_id
        AND MONTH(punch_date) = MONTH(CONCAT(@month, '-01'))
    );


   -- calculate total leave days
    UPDATE temp_processed_salaries ps
    SET ps.total_leaves =(
       SELECT
       IFNULL(SUM(CASE
            WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") >= from_date
                    AND LAST_DAY(CONCAT(@month, "-01")) <= to_date
                THEN (DATEDIFF(to_date, from_date) + 1 -
                    CASE
                        WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") > from_date
                        THEN DATEDIFF(DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d"), from_date)
                        ELSE 0
                    END -
                    CASE
                        WHEN LAST_DAY(CONCAT(@month, "-01")) < to_date
                        THEN DATEDIFF(to_date, LAST_DAY(CONCAT(@month, "-01")))
                        ELSE 0
                    END)
                WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") < from_date
                    AND LAST_DAY(CONCAT(@month, "-01")) > to_date
                THEN DATEDIFF(to_date, from_date) + 1
                WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") > from_date
                    AND @month = DATE_FORMAT(to_date, "%Y-%m")
                THEN DATEDIFF(to_date, from_date) + 1 -
                    CASE
                        WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") > from_date
                        THEN DATEDIFF(DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d"), from_date)
                        ELSE 0
                    END
                WHEN @month = DATE_FORMAT(from_date, "%Y-%m")
                    AND LAST_DAY(CONCAT(@month, "-01")) < to_date
                THEN DATEDIFF(to_date, from_date) + 1 -
                    CASE
                        WHEN LAST_DAY(CONCAT(@month, "-01")) < to_date
                        THEN DATEDIFF(to_date, LAST_DAY(CONCAT(@month, "-01")))
                        ELSE 0
                    END
                ELSE 0
            END), 0)
         AS total_days
        FROM
            leave_entries WHERE emp_id = ps.emp_id AND is_approved=1


    );
    -- calculate total working days
    UPDATE temp_processed_salaries ps
    SET ps.total_working_day = (ps.total_working_day + (
       SELECT
       IFNULL(SUM(CASE
            WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") >= from_date
                    AND LAST_DAY(CONCAT(@month, "-01")) <= to_date
                THEN (DATEDIFF(to_date, from_date) + 1 -
                    CASE
                        WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") > from_date
                        THEN DATEDIFF(DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d"), from_date)
                        ELSE 0
                    END -
                    CASE
                        WHEN LAST_DAY(CONCAT(@month, "-01")) < to_date
                        THEN DATEDIFF(to_date, LAST_DAY(CONCAT(@month, "-01")))
                        ELSE 0
                    END)
                WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") < from_date
                    AND LAST_DAY(CONCAT(@month, "-01")) > to_date
                THEN DATEDIFF(to_date, from_date) + 1
                WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") > from_date
                    AND @month = DATE_FORMAT(to_date, "%Y-%m")
                THEN DATEDIFF(to_date, from_date) + 1 -
                    CASE
                        WHEN DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d") > from_date
                        THEN DATEDIFF(DATE_FORMAT(CONCAT(@month, "-01"), "%Y-%m-%d"), from_date)
                        ELSE 0
                    END
                WHEN @month = DATE_FORMAT(from_date, "%Y-%m")
                    AND LAST_DAY(CONCAT(@month, "-01")) < to_date
                THEN DATEDIFF(to_date, from_date) + 1 -
                    CASE
                        WHEN LAST_DAY(CONCAT(@month, "-01")) < to_date
                        THEN DATEDIFF(to_date, LAST_DAY(CONCAT(@month, "-01")))
                        ELSE 0
                    END
                ELSE 0
            END), 0)
         AS total_days
        FROM
            leave_entries WHERE emp_id = ps.emp_id AND is_approved=1
        )
    );


   UPDATE temp_processed_salaries ps
    JOIN employee_salaries es ON ps.emp_id = es.employee_id
    SET ps.house_rent=es.house_rent,
    ps.medical_allowance=es.medical_allowance,
    ps.tansport_allowance=es.tansport_allowance,
    ps.food_allowance=es.food_allowance,
    ps.other_allowance=es.other_allowance,
    ps.mobile_allowance=es.mobile_allowance,
    ps.grade_bonus=es.grade_bonus,
    ps.skill_bonus=es.skill_bonus,
    ps.management_bonus=es.management_bonus,
    ps.income_tax=es.income_tax,
    ps.casual_salary=es.casual_salary,
    ps.total_working_amount = (
        ps.total_working_day *
        (
        SELECT
            ROUND(basic_salary / (30), 0) AS daily_amount
        from employee_salaries WHERE employee_id= ps.emp_id
        )
    );


    UPDATE temp_processed_salaries ps
    JOIN processed_attendances pa ON ps.emp_id = pa.emp_id
        AND MONTH(pa.punch_date) = MONTH(CONCAT(@month, '-01'))
        AND pa.department_id = @Department
    SET ps.total_late_hour = (
        SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(late))), '%H:%i:%s') AS count_late_hour
        FROM processed_attendances
        WHERE status IN ('p', 'l', 'w', 'h') AND ps.emp_id = emp_id
        AND MONTH(punch_date) = MONTH(CONCAT(@month, '-01'))
    );
    -- calculate sum ot hour
    UPDATE temp_processed_salaries ps
    JOIN processed_attendances pa ON ps.emp_id = pa.emp_id
        AND MONTH(pa.punch_date) = MONTH(CONCAT(@month, '-01'))
        AND pa.department_id = @Department
    SET ps.total_ot_hour = (
        SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(ot_hour))), '%H:%i:%s') AS count_ot_hour
        FROM processed_attendances
        WHERE status IN ('p', 'l', 'w', 'h') AND emp_id = ps.emp_id
        AND MONTH(punch_date) = MONTH(CONCAT(@month, '-01'))
    );

    -- calculate total ot amount
    UPDATE temp_processed_salaries ps
    JOIN employee_salaries es ON ps.emp_id = es.employee_id
        AND MONTH(CONCAT(ps.month, '-01')) = MONTH(CONCAT(@month, '-01'))
    SET ps.total_ot_amount = (
        SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(ot_hour))), '%H') *
        (
        SELECT
            CASE
                WHEN ot_calculation_basis = 'basic' THEN
                    ROUND(basic_salary / (30 * 8), 0)
                WHEN ot_calculation_basis = 'gross' THEN
                    ROUND(gross_salary / (30 * 8), 0)
                ELSE
                    0
            END AS ot_amount
        from employee_salaries WHERE employee_id= ps.emp_id
        ) + ((        SELECT
            CASE
                WHEN ot_calculation_basis = 'basic' THEN
                    ROUND(basic_salary / (30 * 8), 0)
                WHEN ot_calculation_basis = 'gross' THEN
                    ROUND(gross_salary / (30 * 8), 0)
                ELSE
                    0
            END AS ot_amount
        from employee_salaries WHERE employee_id= ps.emp_id)  * (SELECT
         ot_salary/100 AS ot_percent
        from employee_salaries WHERE employee_id= ps.emp_id
		  ))
        AS count_ot_amount
        FROM processed_attendances
        WHERE status IN ('p', 'l', 'w', 'h') AND emp_id = ps.emp_id
        AND MONTH(punch_date) = MONTH(CONCAT(@month, '-01'))
    );


   UPDATE temp_processed_salaries ps
	    JOIN salary_adjustments sa ON ps.emp_id = sa.employee_id
	        AND MONTH(CONCAT(sa.month_year, '-01')) = MONTH(CONCAT(@month, '-01'))
	    SET ps.adjustment_amount = (
	            SELECT
	            IFNULL(
	                CASE
	                    WHEN type = 'addition' THEN
	                        amount
	                    WHEN type = 'deduction' THEN
	                        CONCAT('-',amount)
	                    ELSE
	                        0
	                END,'0')
	           AS ot_amount
	        FROM salary_adjustments
	        WHERE  employee_id =ps.emp_id
	        AND MONTH(CONCAT(month_year, '-01')) = MONTH(CONCAT(@month, '-01'))
    );

            -- calculate total_late_day
    UPDATE temp_processed_salaries ps
    JOIN processed_attendances pa ON ps.emp_id = pa.emp_id
        AND MONTH(pa.punch_date) = MONTH(CONCAT(@month, '-01'))
        AND pa.department_id = @Department
    SET ps.total_late_day = (
        SELECT COUNT(*) AS count_of_days
        FROM processed_attendances
        WHERE status IN ('l') AND emp_id = ps.emp_id
        AND MONTH(punch_date) = MONTH(CONCAT(@month, '-01'))
    );

    Insert INTO processed_salaries(emp_id,employee_type_id, department_id, section_id, shift_id, designation_id, month, total_working_day, total_working_amount, total_late_hour,total_late_day, total_late_amount, total_ot_hour, total_ot_amount,total_leaves, adjustment_amount,house_rent,medical_allowance,tansport_allowance,food_allowance,other_allowance,mobile_allowance,grade_bonus,skill_bonus,management_bonus,income_tax,casual_salary,com_id,cost_center_id)
    SELECT emp_id,employee_type_id, department_id, section_id, shift_id, designation_id, month, total_working_day, total_working_amount, total_late_hour,total_late_day, total_late_amount, total_ot_hour, total_ot_amount,total_leaves, adjustment_amount,house_rent,medical_allowance,tansport_allowance,food_allowance,other_allowance,mobile_allowance,grade_bonus,skill_bonus,management_bonus,income_tax,casual_salary,com_id,@CostCenter
    FROM temp_processed_salaries;

    Truncate table temp_processed_salaries;
END
