<?php


Route::get('admin', function () {

    if (Auth::guard('admin')->check()) {

        return redirect('admin/Dashboard');
    } else {
        return view('auth.login_admin');
    }

})->name('admin');


Route::post('admin_login', 'Admin\LoginController@admin_login')->name('admin_login');

Route::get('admin/Dashboard','Admin\DashboardController@index')->name('admin/Dashboard');

Route::get('logout_admin', function () {
    Auth::guard('admin')->logout();
    //Session::flush();
    return view('auth.login_admin');
  })->name('logout_admin');

Route::get('admin/Blank', function () {
    return view('backend.blank');
  })->name('admin/Blank');




  // Route::get('admin/MemberRegister', function () {
  //   return view('backend.member_regis');
  // })->name('admin/MemberRegister');
  Route::get('admin/MemberRegister','Admin\MemberRigisterController@index')->name('admin/MemberRegister');
  Route::get('admin/MemberRegister_datatable','Admin\MemberRigisterController@MemberRegister_datatable')->name('admin/MemberRegister_datatable');
  Route::get('admin/view_password','Admin\MemberRigisterController@view_password')->name('admin/view_password');
  Route::post('admin/edit_password','Admin\MemberRigisterController@edit_password')->name('admin/edit_password');

  Route::post('admin/edit_position','Admin\MemberRigisterController@edit_position')->name('admin/edit_position');



  Route::get('admin/view_member_data','Admin\MemberRigisterController@view_member_data')->name('admin/view_member_data');
  Route::post('admin/cancel_member','Admin\MemberRigisterController@cancel_member')->name('admin/cancel_member');

  // Route::get('admin/MemberDocument', function () {
  //   return view('backend.member_doc');
  // })->name('admin/MemberDocument');
  Route::get('admin/MemberDoc','Admin\MemberDocController@index')->name('admin/MemberDoc');
  Route::get('admin/Member_Doc_datatable','Admin\MemberDocController@Member_Doc_datatable')->name('admin/Member_Doc_datatable');
  Route::post('admin/Member_Doc_update','Admin\MemberDocController@Member_Doc_update')->name('admin/Member_Doc_update');
  Route::get('admin/Member_Doc_view','Admin\MemberDocController@Member_Doc_view')->name('admin/Member_Doc_view');
  Route::get('admin/Member_Acc_view','Admin\MemberDocController@Member_Acc_view')->name('admin/Member_Acc_view');
  Route::post('admin/Member_Acc_update','Admin\MemberDocController@Member_Acc_update')->name('admin/Member_Acc_update');

  // Route::get('admin/HistoryDocument', function () {
  //   return view('backend.history_doc');
  // })->name('admin/HistoryDocument');
  Route::get('admin/HistoryDocument','Admin\DocHistoryController@index')->name('admin/HistoryDocument');
  Route::get('admin/History_Doc_datatable','Admin\DocHistoryController@History_Doc_datatable')->name('admin/History_Doc_datatable');
  Route::get('admin/History_Doc_view','Admin\DocHistoryController@History_Doc_view')->name('admin/History_Doc_view');
  Route::get('admin/History_Acc_view','Admin\DocHistoryController@History_Acc_view')->name('admin/History_Acc_view');
  Route::post('admin/History_Acc_update','Admin\DocHistoryController@History_Acc_update')->name('admin/History_Acc_update');


  Route::get('admin/News','Admin\NewsController@index')->name('admin/News');
  Route::post('admin/News_insert','Admin\NewsController@insert')->name('admin/News_insert');
  Route::get('admin/view_news','Admin\NewsController@view_news')->name('admin/view_news');
  Route::post('admin/edit_news','Admin\NewsController@edit_news')->name('admin/edit_news');
  Route::get('admin/news_datatable','Admin\NewsController@news_datatable')->name('admin/news_datatable');

  Route::get('admin/Learning','Admin\LearningController@index')->name('admin/Learning');
  Route::post('admin/learning_insert','Admin\LearningController@insert')->name('admin/learning_insert');
  Route::get('admin/view_learning','Admin\LearningController@view_learning')->name('admin/view_learning');
  Route::post('admin/edit_learning','Admin\LearningController@edit_learning')->name('admin/edit_learning');
  Route::get('admin/learning_datatable','Admin\LearningController@learning_datatable')->name('admin/learning_datatable');



  // Route::get('admin/Products', function () {
  //   return view('backend.products');
  // })->name('admin/Products');
  Route::get('admin/Products','Admin\ProductsController@index')->name('admin/Products');
  Route::post('admin/Products_insert','Admin\ProductsController@insert')->name('admin/Products_insert');
  Route::get('admin/view_products','Admin\ProductsController@view_products')->name('admin/view_products');
  Route::post('admin/edit_products','Admin\ProductsController@edit_products')->name('admin/edit_products');


  Route::get('admin/Products_promotion','Admin\ProductsController@index_promotion')->name('admin/Products_promotion');
  Route::post('admin/Products_insert_promotion','Admin\ProductsController@insert_promotion')->name('admin/Products_insert_promotion');
  Route::get('admin/view_products_promotion','Admin\ProductsController@view_products_promotion')->name('admin/view_products_promotion');
  Route::post('admin/edit_products_promotion','Admin\ProductsController@edit_products_promotion')->name('admin/edit_products_promotion');


  Route::get('admin/EditProfile', function () {
    return view('backend.admin_edit_member');
  })->name('admin/EditProfile');


  // Route::get('admin/AdminData', function () {
  //   return view('backend.admin_data');
  // })->name('admin/AdminData');
  Route::get('admin/AdminData','Admin\AdminDataController@index')->name('admin/AdminData');
  Route::post('admin/AdminData_insert','Admin\AdminDataController@insert')->name('admin/AdminData_insert');
  Route::get('admin/view_admin_data','Admin\AdminDataController@view_admin_data')->name('admin/view_admin_data');
  Route::post('admin/edit_admin_data','Admin\AdminDataController@edit_admin_data')->name('admin/edit_admin_data');



  // Route::get('admin/Category', function () {
  //   return view('backend.category');
  // })->name('admin/Category');
  Route::get('admin/Category','Admin\CategoryController@index')->name('admin/Category');
  Route::post('admin/Category_insert','Admin\CategoryController@insert')->name('admin/Category_insert');
  Route::get('admin/view_category','Admin\CategoryController@view_category')->name('admin/view_category');
  Route::post('admin/edit_category','Admin\CategoryController@edit_category')->name('admin/edit_category');


  // Route::get('admin/Bank', function () {
  //   return view('backend.bank');
  // })->name('admin/Bank');
  Route::get('admin/Bank','Admin\BankController@index')->name('admin/Bank');
  Route::post('admin/Bank_insert','Admin\BankController@insert')->name('admin/Bank_insert');
  Route::get('admin/view_bank','Admin\BankController@view_bank')->name('admin/view_bank');
  Route::post('admin/edit_bank','Admin\BankController@edit_bank')->name('admin/edit_bank');


  // Route::get('admin/Unit', function () {
  //   return view('backend.unit');
  // })->name('admin/Unit');
  Route::get('admin/Unit','Admin\UnitController@index')->name('admin/Unit');
  Route::post('admin/Unit_insert','Admin\UnitController@insert')->name('admin/Unit_insert');
  Route::get('admin/view_unit','Admin\UnitController@view_unit')->name('admin/view_unit');
  Route::post('admin/edit_unit','Admin\UnitController@edit_unit')->name('admin/edit_unit');


  // Route::get('admin/Branch', function () {
  //   return view('backend.branch');
  // })->name('admin/Branch');
  Route::get('admin/Branch','Admin\BranchController@index')->name('admin/Branch');
  Route::post('admin/Branch_insert','Admin\BranchController@insert')->name('admin/Branch_insert');
  Route::get('admin/view_branch','Admin\BranchController@view_branch')->name('admin/view_branch');
  Route::post('admin/edit_branch','Admin\BranchController@edit_branch')->name('admin/edit_branch');

  // Route::get('admin/Warehouse', function () {
  //   return view('backend.Warehouse');
  // })->name('admin/Warehouse');
  Route::get('admin/Warehouse','Admin\WarehouseController@index')->name('admin/Warehouse');
  Route::post('admin/Warehouse_insert','Admin\WarehouseController@insert')->name('admin/Warehouse_insert');
  Route::get('admin/view_warehouse','Admin\WarehouseController@view_warehouse')->name('admin/view_warehouse');
  Route::post('admin/edit_warehouse','Admin\WarehouseController@edit_warehouse')->name('admin/edit_warehouse');

  // Route::get('admin/Stock_in', function () {
  //   return view('backend.Stock_in');
  // })->name('admin/Stock_in');
  Route::get('admin/Stock_in','Admin\StockController@index')->name('admin/Stock_in');
  Route::get('admin/get_data_warehouse_select', 'Admin\StockController@get_data_warehouse_select')->name('get_data_warehouse_select');
  Route::get('admin/get_data_product_unit_select', 'Admin\StockController@get_data_product_unit_select')->name('get_data_product_unit_select');
  Route::post('admin/Stockin_insert','Admin\StockController@insert')->name('admin/Stockin_insert');
  Route::get('admin/view_stock_in','Admin\StockController@view_stock_in')->name('admin/view_stock_in');
  Route::post('admin/update_stock_in','Admin\StockController@update_stock_in')->name('admin/update_stock_in');

  Route::get('admin/Stock_in_confirm_datatable','Admin\StockController@Stock_in_confirm_datatable')->name('admin/Stock_in_confirm_datatable');
    // END receive

  // Route::get('admin/Stock_out', function () {
  //   return view('backend.Stock_out');
  // })->name('admin/Stock_out');
  Route::get('admin/Stock_out','Admin\StockOutController@index')->name('admin/Stock_out');
  Route::get('admin/Stock_out_detail/{id}','Admin\StockOutController@view_modal')->name('admin/Stock_out_detail');
  Route::get('admin/get_data_warehouse_out_select', 'Admin\StockOutController@get_data_warehouse_out_select')->name('admin/get_data_warehouse_out_select');
  Route::post('admin/Stockout_insert','Admin\StockOutController@insert')->name('admin/Stockout_insert');
  Route::get('admin/view_stock_out','Admin\StockOutController@view_stock_out')->name('admin/view_stock_out');
  Route::post('admin/update_stock_out','Admin\StockOutController@update_stock_out')->name('admin/update_stock_out');
  Route::get('admin/Stock_out_confirm_datatable','Admin\StockOutController@Stock_out_confirm_datatable')->name('admin/Stock_out_confirm_datatable');


  // Route::get('admin/Stock_report', function () {
  //   return view('backend.Stock_report');
  // })->name('admin/Stock_report');
  Route::get('admin/Stock_report','Admin\StockReportController@index')->name('admin/Stock_report');
  Route::get('admin/get_data_warehouse_select', 'Admin\StockReportController@get_data_warehouse_select')->name('get_data_warehouse_select');
  Route::get('admin/Stock_report_datatable','Admin\StockReportController@Stock_report_datatable')->name('admin/Stock_report_datatable');


  // Route::get('admin/Stock_card', function () {
  //   return view('backend.Stock_card');
  // })->name('admin/Stock_card');
  Route::get('admin/Stock_card/{lot_id}','Admin\StockCardController@index')->name('admin/Stock_card');
  Route::get('admin/Stock_card_datatable','Admin\StockCardController@Stock_card_datatable')->name('admin/Stock_card_datatable');


      // BEGIN eWallet
      Route::get('admin/eWallet', 'Admin\eWalletController@index')->name('admin/eWallet');
      Route::get('admin/withdraw', 'Admin\eWalletController@withdraw')->name('admin/withdraw');
      Route::get('admin/transfer', 'Admin\eWalletController@transfer')->name('admin/transfer');
      Route::get('admin/export', 'Admin\eWalletController@export')->name('admin/export');
      Route::get('admin/export2', 'Admin\eWalletController@export2')->name('admin/export2');
      Route::post('admin/import', 'Admin\eWalletController@import')->name('admin/import');
      Route::get('admin/get_ewallet', 'Admin\eWalletController@get_ewallet')->name('admin/get_ewallet');
      Route::get('admin/get_transfer', 'Admin\eWalletController@get_transfer')->name('admin/get_transfer');
      Route::get('admin/get_withdraw', 'Admin\eWalletController@get_withdraw')->name('admin/get_withdraw');
      Route::post('admin/get_info_ewallet', 'Admin\eWalletController@get_info_ewallet')->name('admin/get_info_ewallet');
      Route::post('admin/get_info_ewallet_withdraw', 'Admin\eWalletController@get_info_ewallet_withdraw')->name('admin/get_info_ewallet_withdraw');

      Route::post('admin/approve_ewallet_withdraw', 'Admin\eWalletController@approve_ewallet_withdraw')->name('admin/approve_ewallet_withdraw');
      Route::post('admin/cancle_ewallet_withdraw', 'Admin\eWalletController@cancle_ewallet_withdraw')->name('admin/cancle_ewallet_withdraw');



      Route::post('admin/approve_update_ewallet', 'Admin\eWalletController@approve_update_ewallet')->name('admin/approve_update_ewallet');
      Route::post('admin/disapproved_update_ewallet', 'Admin\eWalletController@disapproved_update_ewallet')->name('admin/disapproved_update_ewallet');


      // BEGIN Order
    Route::get('admin/orders/list', 'Admin\OrderController@orders_list')->name('admin/orders/list');
    Route::get('admin/orders/product_list_view', 'Admin\OrderController@product_list_view')->name('admin/orders/product_list_view');


    Route::get('admin/orders/get_data_order_list', 'Admin\OrderController@get_data_order_list')->name('admin/orders/get_data_order_list');

    Route::get('admin/orders/list_success', 'Admin\OrderController@orders_success')->name('admin/orders/list_success');
    Route::get('admin/orders/get_data_order_list_success', 'Admin\OrderController@get_data_order_list_success')->name('admin/orders/get_data_order_list_success');

    Route::get('admin/orders/list_stock', 'Admin\OrderController@list_stock')->name('admin/orders/list_stock');
    Route::get('admin/orders/get_data_order_list_stock', 'Admin\OrderController@get_data_order_list_stock')->name('admin/orders/get_data_order_list_stock');



    Route::post('admin/orders/tracking_no', 'Admin\OrderController@tracking_no')->name('admin/orders/tracking_no');


    Route::get('orderexport/{date_start}/{date_end}', 'Admin\OrderController@orderexport')->name('admin/orders/orderexport');
    Route::post('importorder', 'Admin\OrderController@importorder')->name('admin/orders/importorder');
    Route::get('admin/orders/view_detail_oeder/{code_order}', 'Admin\OrderController@view_detail_oeder')->name('admin/orders/view_detail_oeder');
    Route::get('admin/orders/report_order_pdf/{shipping_type}/{date_start}/{date_end}', 'Admin\OrderController@report_order_pdf')->name('admin/orders/report_order_pdf');

    Route::post('admin/orders/view_detail_oeder_pdf_success/', 'Admin\OrderController@view_detail_oeder_pdf_success')->name('admin/orders/view_detail_oeder_pdf_success');


    Route::post('admin/orders/tracking_no_sort', 'Admin\OrderController@tracking_no_sort')->name('admin/orders/tracking_no_sort');
    Route::post('admin/orders/view_detail_oeder_pdf/', 'Admin\OrderController@view_detail_oeder_pdf')->name('admin/orders/view_detail_oeder_pdf');

    Route::get('admin/bonus2', 'Admin\BonusController@bonus2')->name('admin/bonus2');

    Route::get('admin/view_cashback', 'Admin\ProductsController@view_cashback')->name('admin/view_cashback');
    Route::get('admin/add_cashback', 'Admin\ProductsController@add_cashback')->name('admin/add_cashback');
    Route::get('admin/delete_cashback', 'Admin\ProductsController@delete_cashback')->name('admin/delete_cashback');

    Route::get('admin/bonus2_detail/{user_name}', 'Admin\BonusController@bonus2_detail')->name('admin/bonus2_detail');

    Route::post('admin/run_bonus2', 'Admin\BonusController@run_bonus2')->name('admin/run_bonus2');
    Route::get('admin/datatable_casback', 'Admin\BonusController@datatable_casback')->name('admin/datatable_casback');

    Route::get('admin/datatable_casback_detail', 'Admin\BonusController@datatable_casback_detail')->name('admin/datatable_casback_detail');


    Route::get('admin/bonus3', 'Admin\Bonus3Controller@bonus3')->name('admin/bonus3');
    Route::post('admin/run_bonus3', 'Admin\Bonus3Controller@run_bonus3')->name('admin/run_bonus3');

    Route::get('admin/datatable_bonus3', 'Admin\Bonus3Controller@datatable_bonus3')->name('admin/datatable_bonus3');


    Route::get('admin/datatable_bonus3_detail', 'Admin\Bonus3Controller@datatable_bonus3_detail')->name('admin/datatable_bonus3_detail');

    Route::get('admin/datatable_bonus3_detail', 'Admin\Bonus3Controller@datatable_bonus3_detail')->name('admin/datatable_bonus3_detail');
    Route::get('admin/bonus3_detail/{user_name}', 'Admin\Bonus3Controller@bonus3_detail')->name('admin/bonus3_detail');


    Route::get('admin/bonus7', 'Admin\Bonus7Controller@bonus7')->name('admin/bonus7');
    Route::post('admin/run_bonus7', 'Admin\Bonus7Controller@run_bonus7')->name('admin/run_bonus7');

    Route::get('admin/datatable_bonus7', 'Admin\Bonus7Controller@datatable_bonus7')->name('admin/datatable_bonus7');



    Route::get('admin/pv_per_month', 'Admin\Pv_per_monthController@pv_per_month')->name('admin/pv_per_month');
    Route::post('admin/run_pv_per_month', 'Admin\Pv_per_monthController@run_pv_per_month')->name('admin/run_pv_per_month');

    Route::get('admin/datatable_pv_per_month', 'Admin\Pv_per_monthController@datatable_pv_per_month')->name('admin/datatable_pv_per_month');


    Route::get('admin/bonus8', 'Admin\Bonus8Controller@bonus8')->name('admin/bonus8');
    Route::post('admin/run_bonus8', 'Admin\Bonus8Controller@run_bonus8')->name('admin/run_bonus8');
    Route::get('admin/datatable_bonus8', 'Admin\Bonus8Controller@datatable_bonus8')->name('admin/datatable_bonus8');


    Route::get('admin/bonus4', 'Admin\Bonus4Controller@bonus4')->name('admin/bonus4');
    Route::post('admin/run_bonus4', 'Admin\Bonus4Controller@run_bonus4')->name('admin/run_bonus4');
    Route::get('admin/datatable_bonus4', 'Admin\Bonus4Controller@datatable_bonus4')->name('admin/datatable_bonus4');


    Route::get('admin/datatable_bonus4_detail', 'Admin\Bonus4Controller@datatable_bonus4_detail')->name('admin/datatable_bonus4_detail');
    Route::get('admin/bonus4_detail/{user_name}', 'Admin\Bonus4Controller@bonus4_detail')->name('admin/bonus4_detail');
















