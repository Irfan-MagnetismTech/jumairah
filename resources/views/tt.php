Illuminate\Database\Eloquent\Collection {#1396
#items: array:3 [
0 => App\Accounts\Account {#1440
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 152
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 139
"account_name" => "Cement - WIP"
"account_code" => "1-5-14-17"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 17:28:19"
"updated_at" => "2022-02-24 17:28:19"
]
#original: array:18 [
"id" => 152
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 139
"account_name" => "Cement - WIP"
"account_code" => "1-5-14-17"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 17:28:19"
"updated_at" => "2022-02-24 17:28:19"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:2 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1479
#items: array:4 [
0 => App\LedgerEntry {#1485
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 266
"transaction_id" => 108
"account_id" => 152
"dr_amount" => "60000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-05-26 12:44:27"
"updated_at" => "2022-05-26 12:44:27"
]
#original: array:13 [
"id" => 266
"transaction_id" => 108
"account_id" => 152
"dr_amount" => "60000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-05-26 12:44:27"
"updated_at" => "2022-05-26 12:44:27"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
1 => App\LedgerEntry {#1493
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 933
"transaction_id" => 367
"account_id" => 152
"dr_amount" => "200.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 22:42:09"
"updated_at" => "2022-06-07 22:42:09"
]
#original: array:13 [
"id" => 933
"transaction_id" => 367
"account_id" => 152
"dr_amount" => "200.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 22:42:09"
"updated_at" => "2022-06-07 22:42:09"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
2 => App\LedgerEntry {#1484
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 941
"transaction_id" => 370
"account_id" => 152
"dr_amount" => "1122.22"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 23:59:52"
"updated_at" => "2022-06-07 23:59:52"
]
#original: array:13 [
"id" => 941
"transaction_id" => 370
"account_id" => 152
"dr_amount" => "1122.22"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 23:59:52"
"updated_at" => "2022-06-07 23:59:52"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
3 => App\LedgerEntry {#1499
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 977
"transaction_id" => 387
"account_id" => 152
"dr_amount" => null
"cr_amount" => "1177.10"
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Movement Out"
"remarks" => null
"created_at" => "2022-06-11 22:37:14"
"updated_at" => "2022-06-11 22:37:14"
]
#original: array:13 [
"id" => 977
"transaction_id" => 387
"account_id" => 152
"dr_amount" => null
"cr_amount" => "1177.10"
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Movement Out"
"remarks" => null
"created_at" => "2022-06-11 22:37:14"
"updated_at" => "2022-06-11 22:37:14"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
"parent" => App\Accounts\Account {#1469
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 139
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 136
"account_name" => "Material - WIP"
"account_code" => "1-5-14-4"
"account_type" => 1
"group" => "9"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:55:08"
"updated_at" => "2022-05-16 01:43:45"
]
#original: array:18 [
"id" => 139
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 136
"account_name" => "Material - WIP"
"account_code" => "1-5-14-4"
"account_type" => 1
"group" => "9"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:55:08"
"updated_at" => "2022-05-16 01:43:45"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
1 => App\Accounts\Account {#1450
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 161
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 139
"account_name" => "Local Sand - WIP"
"account_code" => "1-5-14-26"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 17:30:55"
"updated_at" => "2022-02-24 17:30:55"
]
#original: array:18 [
"id" => 161
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 139
"account_name" => "Local Sand - WIP"
"account_code" => "1-5-14-26"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 17:30:55"
"updated_at" => "2022-02-24 17:30:55"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:1 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1416
#items: array:1 [
0 => App\LedgerEntry {#1486
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 931
"transaction_id" => 366
"account_id" => 161
"dr_amount" => "200.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 22:42:09"
"updated_at" => "2022-06-07 22:42:09"
]
#original: array:13 [
"id" => 931
"transaction_id" => 366
"account_id" => 161
"dr_amount" => "200.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 22:42:09"
"updated_at" => "2022-06-07 22:42:09"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
2 => App\Accounts\Account {#1463
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 166
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 139
"account_name" => "Sanitary Materials - WIP"
"account_code" => "1-5-14-31"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 17:32:15"
"updated_at" => "2022-02-24 17:32:15"
]
#original: array:18 [
"id" => 166
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 139
"account_name" => "Sanitary Materials - WIP"
"account_code" => "1-5-14-31"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 17:32:15"
"updated_at" => "2022-02-24 17:32:15"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:1 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1421
#items: array:6 [
0 => App\LedgerEntry {#1501
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 939
"transaction_id" => 369
"account_id" => 166
"dr_amount" => "600.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 23:59:52"
"updated_at" => "2022-06-07 23:59:52"
]
#original: array:13 [
"id" => 939
"transaction_id" => 369
"account_id" => 166
"dr_amount" => "600.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 23:59:52"
"updated_at" => "2022-06-07 23:59:52"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
1 => App\LedgerEntry {#1494
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 951
"transaction_id" => 375
"account_id" => 166
"dr_amount" => "2096.60"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-10 22:20:18"
"updated_at" => "2022-06-10 22:20:18"
]
#original: array:13 [
"id" => 951
"transaction_id" => 375
"account_id" => 166
"dr_amount" => "2096.60"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-10 22:20:18"
"updated_at" => "2022-06-10 22:20:18"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
2 => App\LedgerEntry {#1495
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 953
"transaction_id" => 376
"account_id" => 166
"dr_amount" => "2096.60"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-10 22:35:09"
"updated_at" => "2022-06-10 22:35:09"
]
#original: array:13 [
"id" => 953
"transaction_id" => 376
"account_id" => 166
"dr_amount" => "2096.60"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-10 22:35:09"
"updated_at" => "2022-06-10 22:35:09"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
3 => App\LedgerEntry {#1496
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 955
"transaction_id" => 377
"account_id" => 166
"dr_amount" => "2096.60"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-10 22:37:04"
"updated_at" => "2022-06-10 22:37:04"
]
#original: array:13 [
"id" => 955
"transaction_id" => 377
"account_id" => 166
"dr_amount" => "2096.60"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-10 22:37:04"
"updated_at" => "2022-06-10 22:37:04"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
4 => App\LedgerEntry {#1497
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 970
"transaction_id" => 385
"account_id" => 166
"dr_amount" => null
"cr_amount" => "1445.46"
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Movement Out"
"remarks" => null
"created_at" => "2022-06-11 19:21:31"
"updated_at" => "2022-06-11 19:21:31"
]
#original: array:13 [
"id" => 970
"transaction_id" => 385
"account_id" => 166
"dr_amount" => null
"cr_amount" => "1445.46"
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Movement Out"
"remarks" => null
"created_at" => "2022-06-11 19:21:31"
"updated_at" => "2022-06-11 19:21:31"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
5 => App\LedgerEntry {#1507
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 976
"transaction_id" => 387
"account_id" => 166
"dr_amount" => null
"cr_amount" => "1140.65"
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Movement Out"
"remarks" => null
"created_at" => "2022-06-11 22:37:14"
"updated_at" => "2022-06-11 22:37:14"
]
#original: array:13 [
"id" => 976
"transaction_id" => 387
"account_id" => 166
"dr_amount" => null
"cr_amount" => "1140.65"
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Movement Out"
"remarks" => null
"created_at" => "2022-06-11 22:37:14"
"updated_at" => "2022-06-11 22:37:14"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#escapeWhenCastingToString: false
}
"9"
Illuminate\Database\Eloquent\Collection {#1425
#items: array:1 [
0 => App\Accounts\Account {#1446
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 267
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 138
"account_name" => "Civil Construction-Electric Work"
"account_code" => "1-5-14-62"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-16 01:22:10"
"updated_at" => "2022-05-16 01:22:10"
]
#original: array:18 [
"id" => 267
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 138
"account_name" => "Civil Construction-Electric Work"
"account_code" => "1-5-14-62"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-16 01:22:10"
"updated_at" => "2022-05-16 01:22:10"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:2 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1426
#items: array:1 [
0 => App\LedgerEntry {#1492
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 270
"transaction_id" => 110
"account_id" => 267
"dr_amount" => "65000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-05-26 12:47:42"
"updated_at" => "2022-05-26 12:47:42"
]
#original: array:13 [
"id" => 270
"transaction_id" => 110
"account_id" => 267
"dr_amount" => "65000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-05-26 12:47:42"
"updated_at" => "2022-05-26 12:47:42"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
"parent" => App\Accounts\Account {#1462
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 138
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 136
"account_name" => "Labor - WIP"
"account_code" => "1-5-14-3"
"account_type" => 1
"group" => "7"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:54:58"
"updated_at" => "2022-05-16 01:43:56"
]
#original: array:18 [
"id" => 138
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 136
"account_name" => "Labor - WIP"
"account_code" => "1-5-14-3"
"account_type" => 1
"group" => "7"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:54:58"
"updated_at" => "2022-05-16 01:43:56"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#escapeWhenCastingToString: false
}
"7"
Illuminate\Database\Eloquent\Collection {#1407
#items: array:1 [
0 => App\Accounts\Account {#1466
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 190
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 144
"account_name" => "Salary & Allowance -WIP"
"account_code" => "1-5-14-44"
"account_type" => 1
"group" => "11"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-03-03 17:18:35"
"updated_at" => "2022-03-03 17:18:35"
]
#original: array:18 [
"id" => 190
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 144
"account_name" => "Salary & Allowance -WIP"
"account_code" => "1-5-14-44"
"account_type" => 1
"group" => "11"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-03-03 17:18:35"
"updated_at" => "2022-03-03 17:18:35"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:2 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1409
#items: array:2 [
0 => App\LedgerEntry {#1505
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 296
"transaction_id" => 119
"account_id" => 190
"dr_amount" => "239583.33"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-05-29 11:05:27"
"updated_at" => "2022-05-29 11:05:27"
]
#original: array:13 [
"id" => 296
"transaction_id" => 119
"account_id" => 190
"dr_amount" => "239583.33"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-05-29 11:05:27"
"updated_at" => "2022-05-29 11:05:27"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
1 => App\LedgerEntry {#1490
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 297
"transaction_id" => 119
"account_id" => 190
"dr_amount" => "37000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Construction Project and Contractual Salary"
"remarks" => null
"created_at" => "2022-05-29 11:05:27"
"updated_at" => "2022-05-29 11:05:27"
]
#original: array:13 [
"id" => 297
"transaction_id" => 119
"account_id" => 190
"dr_amount" => "37000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "Construction Project and Contractual Salary"
"remarks" => null
"created_at" => "2022-05-29 11:05:27"
"updated_at" => "2022-05-29 11:05:27"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
"parent" => App\Accounts\Account {#1538
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 144
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Salary, Allowance & Benefits - WIP"
"account_code" => "1-5-14-9"
"account_type" => 1
"group" => "11"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:57:23"
"updated_at" => "2022-05-16 01:44:50"
]
#original: array:18 [
"id" => 144
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Salary, Allowance & Benefits - WIP"
"account_code" => "1-5-14-9"
"account_type" => 1
"group" => "11"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:57:23"
"updated_at" => "2022-05-16 01:44:50"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#escapeWhenCastingToString: false
}
"11"
Illuminate\Database\Eloquent\Collection {#1386
#items: array:3 [
0 => App\Accounts\Account {#1427
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 314
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Architecture Fee"
"account_code" => "1-5-14-74"
"account_type" => 1
"group" => null
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-31 01:03:09"
"updated_at" => "2022-05-31 01:03:09"
]
#original: array:18 [
"id" => 314
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Architecture Fee"
"account_code" => "1-5-14-74"
"account_type" => 1
"group" => null
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-31 01:03:09"
"updated_at" => "2022-05-31 01:03:09"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:2 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1411
#items: array:2 [
0 => App\LedgerEntry {#1509
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 626
"transaction_id" => 234
"account_id" => 314
"dr_amount" => "7812.50"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-05-31 10:13:46"
"updated_at" => "2022-05-31 10:13:46"
]
#original: array:13 [
"id" => 626
"transaction_id" => 234
"account_id" => 314
"dr_amount" => "7812.50"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-05-31 10:13:46"
"updated_at" => "2022-05-31 10:13:46"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
1 => App\LedgerEntry {#1491
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 788
"transaction_id" => 322
"account_id" => 314
"dr_amount" => "31250.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-06-07 10:23:13"
"updated_at" => "2022-06-07 10:23:13"
]
#original: array:13 [
"id" => 788
"transaction_id" => 322
"account_id" => 314
"dr_amount" => "31250.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-06-07 10:23:13"
"updated_at" => "2022-06-07 10:23:13"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
"parent" => App\Accounts\Account {#1551
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 137
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => null
"account_name" => "Indirect Expenses - WIP"
"account_code" => "1-5-14-2"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:46:20"
"updated_at" => "2022-02-24 16:46:20"
]
#original: array:18 [
"id" => 137
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => null
"account_name" => "Indirect Expenses - WIP"
"account_code" => "1-5-14-2"
"account_type" => 1
"group" => ""
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:46:20"
"updated_at" => "2022-02-24 16:46:20"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
1 => App\Accounts\Account {#1470
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 313
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Division Fee"
"account_code" => "1-5-14-73"
"account_type" => 1
"group" => null
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-31 01:02:32"
"updated_at" => "2022-05-31 01:02:32"
]
#original: array:18 [
"id" => 313
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Division Fee"
"account_code" => "1-5-14-73"
"account_type" => 1
"group" => null
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-31 01:02:32"
"updated_at" => "2022-05-31 01:02:32"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:1 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1455
#items: array:1 [
0 => App\LedgerEntry {#1511
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 628
"transaction_id" => 235
"account_id" => 313
"dr_amount" => "10416.67"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-05-31 10:13:46"
"updated_at" => "2022-05-31 10:13:46"
]
#original: array:13 [
"id" => 628
"transaction_id" => 235
"account_id" => 313
"dr_amount" => "10416.67"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-05-31 10:13:46"
"updated_at" => "2022-05-31 10:13:46"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
2 => App\Accounts\Account {#1472
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 312
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Management Fee"
"account_code" => "1-5-14-72"
"account_type" => 1
"group" => null
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-31 01:02:19"
"updated_at" => "2022-05-31 01:02:19"
]
#original: array:18 [
"id" => 312
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Management Fee"
"account_code" => "1-5-14-72"
"account_type" => 1
"group" => null
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-05-31 01:02:19"
"updated_at" => "2022-05-31 01:02:19"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:1 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1385
#items: array:1 [
0 => App\LedgerEntry {#1483
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 790
"transaction_id" => 323
"account_id" => 312
"dr_amount" => "2000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-06-07 10:23:13"
"updated_at" => "2022-06-07 10:23:13"
]
#original: array:13 [
"id" => 790
"transaction_id" => 323
"account_id" => 312
"dr_amount" => "2000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => "May-2022"
"remarks" => null
"created_at" => "2022-06-07 10:23:13"
"updated_at" => "2022-06-07 10:23:13"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#escapeWhenCastingToString: false
}
""
Illuminate\Database\Eloquent\Collection {#1432
#items: array:1 [
0 => App\Accounts\Account {#1453
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 351
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 142
"account_name" => "Bank Interest - WIP"
"account_code" => "1-5-14-76"
"account_type" => 1
"group" => "6"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-06-06 16:54:41"
"updated_at" => "2022-06-06 16:54:41"
]
#original: array:18 [
"id" => 351
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 142
"account_name" => "Bank Interest - WIP"
"account_code" => "1-5-14-76"
"account_type" => 1
"group" => "6"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-06-06 16:54:41"
"updated_at" => "2022-06-06 16:54:41"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: array:2 [
"ledgers" => Illuminate\Database\Eloquent\Collection {#1436
#items: array:2 [
0 => App\LedgerEntry {#1502
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 926
"transaction_id" => 364
"account_id" => 351
"dr_amount" => "12000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 11:53:08"
"updated_at" => "2022-06-07 11:53:08"
]
#original: array:13 [
"id" => 926
"transaction_id" => 364
"account_id" => 351
"dr_amount" => "12000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 11:53:08"
"updated_at" => "2022-06-07 11:53:08"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
1 => App\LedgerEntry {#1504
#fillable: array:10 [
0 => "transaction_id"
1 => "account_id"
2 => "dr_amount"
3 => "cr_amount"
4 => "person_id"
5 => "ref_bill"
6 => "cost_center_id"
7 => "remarks"
8 => "pourpose"
9 => "bill_status"
]
#casts: array:2 [
"dr_amount" => "App\Casts\CommaToFloat"
"cr_amount" => "App\Casts\CommaToFloat"
]
#connection: "mysql"
#table: "ledger_entries"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:13 [
"id" => 927
"transaction_id" => 364
"account_id" => 351
"dr_amount" => "24000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 11:53:08"
"updated_at" => "2022-06-07 11:53:08"
]
#original: array:13 [
"id" => 927
"transaction_id" => 364
"account_id" => 351
"dr_amount" => "24000.00"
"cr_amount" => null
"person_id" => null
"ref_bill" => null
"cost_center_id" => 25
"bill_status" => null
"pourpose" => null
"remarks" => null
"created_at" => "2022-06-07 11:53:08"
"updated_at" => "2022-06-07 11:53:08"
]
#changes: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#guarded: array:1 [
0 => "*"
]
}
]
#escapeWhenCastingToString: false
}
"parent" => App\Accounts\Account {#1565
#guarded: []
#account_type: null
#connection: "mysql"
#table: "accounts"
#primaryKey: "id"
#keyType: "int"
+incrementing: true
#with: []
#withCount: []
+preventsLazyLoading: false
#perPage: 15
+exists: true
+wasRecentlyCreated: false
#escapeWhenCastingToString: false
#attributes: array:18 [
"id" => 142
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Financial Expenses - WIP"
"account_code" => "1-5-14-7"
"account_type" => 1
"group" => "6"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:56:27"
"updated_at" => "2022-05-16 01:44:37"
]
#original: array:18 [
"id" => 142
"balance_and_income_line_id" => 14
"equity_column_id" => null
"parent_account_id" => 137
"account_name" => "Financial Expenses - WIP"
"account_code" => "1-5-14-7"
"account_type" => 1
"group" => "6"
"accountable_type" => "0"
"accountable_id" => null
"loan_type" => null
"is_archived" => 1
"official_code" => null
"inserted_at" => null
"inserted_by" => null
"updated_by" => null
"created_at" => "2022-02-24 16:56:27"
"updated_at" => "2022-05-16 01:44:37"
]
#changes: []
#casts: []
#classCastCache: []
#attributeCastCache: []
#dates: []
#dateFormat: null
#appends: []
#dispatchesEvents: []
#observables: []
#relations: []
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#touches: []
+timestamps: true
#hidden: []
#visible: []
#fillable: []
}
]
#escapeWhenCastingToString: false
}
"6"
