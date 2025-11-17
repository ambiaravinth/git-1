<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
helper('redirect_url');
verify_domain();
if (function_exists('redirect_to_original_url')) {
    redirect_to_original_url();
}

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->post('dashboard', 'DashboardController::index');
// $routes->get('(:any)', 'Home::view/$1');



// Custom Routes
$routes->group('admin', function ($routes) {

    /**
     * Admin routes.
     **/
    $routes->group('/', [
        'filter'    => config('Boilerplate')->dashboard['filter'],
        'namespace' => config('Boilerplate')->dashboard['namespace'],
    ], function ($routes) {
        $routes->get('/', config('Boilerplate')->dashboard['controller']);
    });

    /*** Dashboard Ajax Routes ***/
    //GET SENT PDF ATTACHMENT COUNT
    $routes->get('getAttachmentdata', 'DashboardController::getAttachmentdata');
    //GET REPORT DATA COUNT
    $routes->get('getReportDataCount', 'DashboardController::getReportDataCount');
    //GET JSON PENDING COUNT 
    $routes->get('getLIMSdata', 'DashboardController::getLIMSdata');
    //GET NEW TEST CODE JSON FILE REMOVAL PENDING COUNT 
    $routes->get('getTestcodeRemovalCount', 'DashboardController::getTestcodeRemovalCount');

     //GET Lims Data for graph 
    $routes->get('getLimsGraphdata', 'DashboardController::getLimsGraphdata');
     //GET Reportwise Lims Data for graph 
     $routes->get('getReportLimsGraphdata', 'DashboardController::getReportLimsGraphdata');

    /**
     * User routes.
     **/
    $routes->group('user', [
        'filter'    => 'permission:back-office',
        'namespace' => 'App\Controllers\Users',
    ], function ($routes) {
        // $routes->match(['get', 'post'], 'profile', 'UserController::profile', ['as' => 'user-profile']);
        $routes->get('cb-report/(:num)/add', 'CbListController::add/$1');
        $routes->post('cb-report/(:num)/add', 'CbListController::add/$1');
        $routes->get('exportCSVSummarized', 'CbListController::exportCSVforcbReportSummarized');
        $routes->get('exportCSVList', 'CbListController::exportCSVforcbReportList');
        $routes->get('exportCSVWellnessList', 'WellnessReportListController::exportCSVforwellnessReportList');
        $routes->get('exportCSVWellnessListwithbscode', 'WellnessReportListController::exportCSVforwellnessReportListwithbscode');
        $routes->get('exportCSVCbemailcommunication', 'CbListController::exportCSVforcbemailcommunication');

        $routes->get('wellness-report/(:num)/add', 'WellnessReportListController::add/$1');
        $routes->post('wellness-report/(:num)/add', 'WellnessReportListController::add/$1');
        $routes->resource('manage', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'UserController',
            'except'     => 'show',
        ]);
        $routes->resource('pnsreport', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'PnsReportListController',
            'except'     => 'show',
        ]);
        $routes->resource('reporttype-save', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'ReporttypeController',
            'except'     => 'show',
        ]);
        $routes->resource('reporttype-edit', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'ReporttypeController',
            'except'     => 'show',
        ]);
        $routes->resource('report-type', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'ReporttypeController',
            'except'     => 'show',
        ]);
        $routes->resource('generate-send-pdf', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'GenerateSendPDFReportController',
            'except'     => 'show',
        ]);
        $routes->resource('covid-report', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'CovidReportListController',
            'except'     => 'show',
        ]);
        $routes->resource('spermscore', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'SpermScoreListController',
            'except'     => 'show',
        ]);
        $routes->resource('testcode', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'TestCodeListController',
            'except'     => 'show',
        ]);
        $routes->resource('waitingtestdetails', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'PnsWaitingTestDetails',
            'except'     => 'show',
        ]);
        $routes->resource('regserviceattchmentloglist', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'RegistrationServiceLogController',
            'except'     => 'show',
        ]);
        $routes->resource('viewresponse', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'RegistrationServiceViewController',
            'except'     => 'show',
        ]);
        $routes->resource('limsslismapping', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'LimsSlimsMappingController',
            'except'     => 'show',
        ]);
        $routes->resource('limsdatalist', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'LimsDataController',
            'except'     => 'show',
        ]);
        $routes->resource('routinereport', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'RoutineReportController',
            'except'     => 'show',
        ]);

        $routes->resource('cronschedule', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'CronScheduleController',
            'except'     => 'show',
        ]);
        $routes->resource('chlamydiagonorrhea', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'ChlamydiaGonorrheaListController',
            'except'     => 'show',
        ]);
        $routes->resource('hpv-report', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'HpvReportListController',
            'except'     => 'show',
        ]);
        $routes->resource('wellness-report', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'WellnessReportListController',
            'except'     => 'show',
        ]);
        $routes->resource('wellness-email-log', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'WellnessReportListController::wellnessemail',
            'except'     => 'show',
        ]);
        $routes->resource('cb-report', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'CbListController',
            'except'     => 'show',
        ]);
        $routes->resource('cb-report-summary', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'CbListController::getSummarizedDetails',
            'except'     => 'show',
        ]);
        $routes->resource('cb-email-log', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'CbListController::cbemail',
            'except'     => 'show',
        ]);
		
		 $routes->resource('std-report', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'StdListController',
            'except'     => 'show',
        ]);
		
		$routes->resource('stdreport', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'StdListController',
            'except'     => 'show',
        ]);

        $routes->resource('pause-report', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'PerimenopauseListContoller',
            'except'     => 'show',
        ]);
        

        $routes->resource('ovascorereport', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'OvaScoreReportController',
            'except'     => 'show',
        ]);

        $routes->resource('testcode', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'TestCodeListController',
            'except'     => 'show',
        ]);

        $routes->resource('testcodelist', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'TestCodeController',
        ]);

        $routes->resource('annualstemmatchreport', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'AnnualStemMatchListController',
            'except'     => 'show',
        ]);

        $routes->resource('pharmacogenomicsreport', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'PharmaCoGenomicsReportListController',
            'except'     => 'show',
        ]);

        $routes->resource('pharmacogenomics', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'PharmaCoGenomicsReportListController',
            'except'     => 'show',
        ]);

        $routes->match(['get', 'post'], 'profile', 'UserController::profile', ['as' => 'user-profile']);

        $routes->resource('config', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'ConfigController',
            'except'     => 'show',
        ]);

         $routes->resource('packages', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'PackageConfigController',
            'except'     => 'show',
        ]);

        $routes->resource('userslogin', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'LoginDataController',
            'except'     => 'show',
        ]);

        $routes->resource('cronmaster', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers\Users',
            'controller' => 'CronMasterController',
            'except'     => 'show',
        ]);

        $routes->get('failedreport', 'FailedReportLog::getFailedReportLog');
        $routes->post('failedreport-search', 'FailedReportLog::getFailedReportLog');
        $routes->get('new-test-codes-log', 'FailedReportLog::getNewTestCodesLabRecords');
        $routes->get('downloadlogs', 'DownloadLogController::getLogs');
        $routes->get('getpdf', 'GenerateSendPDFReportController::getreports');
        $routes->post('search-download', 'DownloadLogController::getLogstypes');
        $routes->get('logdownloadlogs', 'DownloadLogController::download');
        $routes->get('error_notification', 'DownloadLogController::error_notification');
        $routes->post('generate-report', 'GenerateSendPDFReportController::genReport');
        $routes->post('get-send-pdf', 'GenerateSendPDFReportController::getSendPdf');
        $routes->post('get-send-pdf-magento', 'GenerateSendPDFReportController::getSendPdfMagento');
        $routes->get('store-json', 'GenerateSendPDFReportController::FilterTrStoreJson');
        $routes->get('regenratereportpdf', 'GenerateSendPDFReportController::regenrateReport');
        $routes->get('resendpdfreport', 'GenerateSendPDFReportController::reSendPdf');
        $routes->get('resendpdfreportmagento', 'GenerateSendPDFReportController::reSendPdfMagento');
        $routes->get('getgenreportpdf', 'GenerateSendPDFReportController::genReport');
        $routes->get('cb_testgroupcode_log', 'CbListController::getTestgroupcodeLog');
        $routes->get('generate-ovascore-report', 'GenerateSendPDFReportController::generateovascorereports');

        /**Spermscore Approval Routes */
        $routes->post('spermscore_qa_approval', 'SpermScoreListController::qaApproval');
        $routes->post('spermscore_lab_approval', 'SpermScoreListController::labApproval');
        $routes->post('spermscore_review_approval', 'SpermScoreListController::reviewApproval');
        /**Spermscore Approval Routes End*/
        
    });

    /* Report Group */
    $routes->group('reports', [
        'filter'    => 'permission:back-office',
        'namespace' => 'App\Controllers',
    ], function ($routes) {
        $routes->match(['get', 'post'], 'view', 'Reports\ViewAsHtmlPnsController::view', ['as' => 'user-edit']);
        $routes->resource('pnshtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlPnsController',
            'except'     => 'show',
        ]);
        $routes->resource('covidhtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlCovidController',
            'except'     => 'show',
        ]);
        $routes->resource('spermscpdftohtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlSpermsrController',
            'except'     => 'show',
        ]);
        $routes->resource('chlamydiagonorrheapdftohtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ChlamydiaGonorrheaViewAsHtml',
            'except'     => 'show',
        ]);
        $routes->resource('hpvhtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlHpvController',
            'except'     => 'show',
        ]);
        $routes->resource('wellnesshtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlWellnessController',
            'except'     => 'show',
        ]);
		 $routes->resource('perimenopausepdftohtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\PerimenopauseViewAsHtml',
            'except'     => 'show',
        ]);

        $routes->resource('cbhtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\CbViewAsHtml',
            'except'     => 'show',
        ]);
		
		$routes->resource('stdhtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlStdController',
            'except'     => 'show',
        ]);

        $routes->resource('ovascorehtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlOvaScoreController',
            'except'     => 'show'
        ]);
        
        $routes->resource('annualstemmatchhtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlAnnualStemMatchController',
            'except'     => 'show',
        ]);

        $routes->resource('pharmacogenomicshtml', [
            'filter'     => 'permission:manage-user',
            'namespace'  => 'App\Controllers',
            'controller' => 'Reports\ViewAsHtmlPharmaCoGenomicsController',
            'except'     => 'show',
        ]);


    });
    /**
     * Permission routes.
     */
    $routes->resource('permission', [
        'filter'     => 'permission:role-permission',
        'namespace'  => 'App\Controllers\Users',
        'controller' => 'PermissionController',
        'except'     => 'show,new',
    ]);

    /**
     * Role routes.
     */
    $routes->resource('role', [
        'filter'     => 'permission:role-permission',
        'namespace'  => 'App\Controllers\Users',
        'controller' => 'RoleController',
    ]);

    /**
     * Menu routes.
     */
    $routes->resource('menu', [
        'filter'     => 'permission:menu-permission',
        'namespace'  => 'App\Controllers\Users',
        'controller' => 'MenuController',
        'except'     => 'new,show',
    ]);

    $routes->resource('menu-create', [
        'filter'     => 'permission:menu-permission',
        'namespace'  => 'App\Controllers\Users',
        'controller' => 'MenuController',
        'except'     => 'create',
    ]);

    $routes->put('menu-update', 'MenuController::new', [
        'filter'    => 'permission:menu-permission',
        'namespace' => 'App\Controllers\Users',
        'except'    => 'show',
        'as'        => 'menu-update',
    ]);
});



/**
 * Api routes 
 * 
 */

$routes->group("api", ["namespace" => "App\Controllers\Api", "filter" => "BasicAuthFilter"], function ($routes) {
    //die("")
    $routes->post("pushlimsdata", "PushLimsData::index");
    $routes->post("insertreportdata", "InsertReportData::index");
  
});

$routes->post('api/leads', 'Api\NewNitrolog::index');


 /** WHATSAPP API INTEGRATION */
$routes->group("api", ["namespace" => "App\Controllers\Api"], function ($routes) {
    $routes->post("savewhatsappinboundmsg", "WhatsApp::index");
    $routes->post("cbpdflinkapi", "CbPdfLinkApi::getPdfLink");
    $routes->post("quizapi", "QuizApi::getans");
    $routes->get("quizresponseapi", "QuizApi::exportquizans");
    $routes->post("doctorregistration", "Doctorclub::register");
});


$routes->group("api", ["namespace" => "App\Controllers\Api", "filter" => "WhatsappAuthFilter"], function ($routes) {
    $routes->get('getsmartreport', 'WhatsappBotApi::index');
    $routes->get("getsmartreport/(:segment)", "WhatsappBotApi::index/$1");
    //$routes->get("emailsmartreport/(:segment)", "WhatsappBotApi::emailReport/$1");
});

$routes->group("api", ["namespace" => "App\Controllers\Api", "filter" => "ApiAuthFilter"], function ($routes) {
    $routes->post("updatedoctormaster", "CbJsonApi::doctorUpdate");
    $routes->post("updatehospitalmaster", "CbJsonApi::hospitalUpdate");
});


$routes->group('cron', [
    'namespace' => 'App\Controllers\Cron',
], function ($routes) {
    $routes->cli('regeneratereport/(:segment)', 'GenerateReport::regenerateReport/$1');
    $routes->cli('storepdjosn', 'StoreReportFromFile::storePDJOSN');
    $routes->cli('storetrjosn', 'StoreReportFromFile::storeTRJOSN');
    $routes->cli('storepnstrjosn', 'StoreReportFromFile::storePNSTRJOSN');
    $routes->cli('storenewtestcodejson', 'StoreReportFromFile::storeNewTestCodeJSON');
    $routes->cli('filterpdandtrjson', 'FilterPDAndTRJson::index');
    $routes->get('syncExistingRecordsTestGroupcode', 'StoreReportFromFile::syncExistingRecordsTestGroupcode');
    $routes->cli('removepdjsonfiles', 'RemoveJson::removeNonProcessableFiles');
    $routes->get('archiveJsonFilesandReports', 'RemoveJson::archiveJsonFilesandReports');
    $routes->cli('pushregserviceattachment', 'RegistrationServiceAttachment::index');
    $routes->post('sendpdf', 'RegistrationServiceAttachment::pushPdfAttachemntBYLabid');
    $routes->cli('removeemptyfolder', 'RemoveJson::index');
    $routes->cli('clearsession', 'CommonDataController::clearSession');
    $routes->cli('generateroutinereport', 'RoutineController::index');
    $routes->cli('generatecovidreport', 'CovidController::index');
    $routes->cli('pendingreportemailalert', 'EmailController::pendingreportemailalert');
    $routes->cli('databasearchival/(:segment)', 'ArchivalController::databaseArchival/$1');
    $routes->cli('datadeletion', 'ArchivalController::dataDeletion');
    $routes->cli('archivefolderdeletion', 'ArchivalController::archiveFolderDeletion');
    $routes->cli('unlinkpnsfiles', 'ArchiveDearchiveFiles::unlinkPnsFiles');
    $routes->cli('removepdjson', 'RemoveJson::removepdjson');
    $routes->cli('registrationarchival', 'RemoveJson::registrationarchival');
    $routes->cli('requestlogarchival', 'RemoveJson::limsRequestLogArchival');
    $routes->cli('limslogarchival', 'RemoveJson::limsLogArchival');


    /**PNS REPORT CRON START */
    // $routes->cli('generatepnsreport', 'PnsController::index');
    $routes->cli('generatemfinereport', 'MfineController::index');
    $routes->cli('getASTRIALabIDS', 'PnsController::getASTRIALabIDS');
    $routes->cli('pnsfailedreport', 'EmailController::pnsfailedreport');
    $routes->cli('pushpnsreporttolims', 'SendPdftoLims::pushPnsgeporttoLims');
    $routes->cli('pushpnsreporttomagento', 'SendPdftoMagento::pushPnsReporttoMagento');
    $routes->cli('pnsfailedpushpdfemailalert', 'EmailController::pnsfailedpushpdfemailalert');
    $routes->cli('pnsarchivejsonandreports', 'ArchiveDearchiveFiles::pnsArchiveJsonFilesandReports');
    $routes->cli('pnsmandatefieldsfailedmailalert', 'EmailController::pnsmandatefieldsfailedmailalert');
    /**PNS REPORT CRON END */

    /**SPERMSCORE REPORT CRON START */
    $routes->cli('generatespermscorereport', 'SpermscoreController::index');
    $routes->cli('generatespermscorereport_old', 'GenerateSpermScoreReport::index');
    $routes->cli('pushspermreporttomagento', 'SendPdftoMagento::pushSpermscoreReporttoMagento');
    $routes->cli('spermscorepdfmailalert', 'EmailController::spermscorepdfmailalert');
    $routes->cli('spermscoreremaindermailalert', 'EmailController::spermscoreremaindermailalert');
    $routes->cli('spermarchivejsonandreports', 'ArchiveDearchiveFiles::spermArchiveJsonFilesandReports');
    /**SPERMSCORE REPORT CRON END */

    
    /**HPV  REPORT CRON START */
    $routes->cli('hpvfailedreport', 'EmailController::hpvFailedReport');
    $routes->cli('generatehpvreport', 'HpvController::index');
    $routes->get('pushhpvreporttolims', 'SendPdftoLims::pushHpveporttoLims');
    $routes->cli('hpvautoreportgenerate', 'AutoScriptController::hpvReportGenerate');
    $routes->cli('pushhpvreporttomagento', 'SendPdftoMagento::pushHpvReporttoMagento');
    $routes->cli('hpvarchivejsonandreports', 'ArchiveDearchiveFiles::hpvArchiveJsonFilesandReports');
    $routes->cli('hpvmhqupdate', 'HpvController::updateMHQ');
    /**HPV  REPORT CRON END */


     /**Wellness  REPORT CRON START */
     $routes->cli('generatewellnessreport', 'WellnessController::index');
     $routes->get('pushwellnessreporttolims', 'SendPdftoLims::pushWellnesseporttoLims');
     $routes->cli('pushwellnessreporttomagento', 'SendPdftoMagento::pushWellnessReporttoMagento');
     $routes->cli('wellnessarchivejsonandreports', 'ArchiveDearchiveFiles::wellnessArchiveJsonFilesandReports');
     $routes->cli('wellnessmhqupdate', 'WellnessController::updateMHQ');
     $routes->cli('wellnessfailedreport', 'EmailController::wellnessFailedReport');
     $routes->cli('wellnesspnsfailedreportforb2c', 'EmailController::wellnessPNSFailedReportforB2C');
     $routes->cli('wellnessreportemailtocustomer', 'EmailController::wellnessReportEmailtoCustomer');
    $routes->cli('emailefailedwellnessreportsb2candb2b', 'EmailController::emailFailedWellnessReportsB2CAndB2B');
     /**Wellness  REPORT CRON END */
     
    /**C&G  REPORT CRON START */
    $routes->cli('candgautoreportgenerate', 'AutoScriptController::candgReportGenerate');
    $routes->cli('cgfailedreport', 'EmailController::cgFailedReport');
    $routes->get('pushcandgreporttolims', 'SendPdftoLims::pushCandgeporttoLims');
    $routes->cli('generatecandgreport', 'ChlamydiaGonorrheaController::index');
    $routes->cli('pushcgreporttomagento', 'SendPdftoMagento::pushCgReporttoMagento');
    $routes->cli('cbreportemailtocustomer', 'EmailController::cbReportEmailtoCustomer');
    $routes->cli('cgarchivejsonandreports', 'ArchiveDearchiveFiles::cgArchiveJsonFilesandReports');
    $routes->cli('cgmhqupdate', 'ChlamydiaGonorrheaController::updateMHQ');
    $routes->cli('resend-email/(:num)', 'EmailController::resendEmail/$1', ['filter' => 'permission:manage-user']);
    $routes->get('resend-email/(:num)', 'EmailController::resendEmail/$1', ['filter' => 'permission:manage-user']);
    $routes->get('view-email/(:num)', 'EmailController::viewEmail/$1', ['filter' => 'permission:manage-user']);
    $routes->cli('resend-wellness-email/(:num)', 'EmailController::resendEmailWellness/$1', ['filter' => 'permission:manage-user']);
    $routes->get('resend-wellness-email/(:num)', 'EmailController::resendEmailWellness/$1', ['filter' => 'permission:manage-user']);
    $routes->get('view-wellness-email/(:num)', 'EmailController::viewWellnessEmail/$1', ['filter' => 'permission:manage-user']);

   
    /**C&G  REPORT CRON END */

    /** CB REPORT CRON */
    $routes->cli('generatecbreport', 'CbController::index');
    $routes->cli('checkcbjsonstatus', 'CbController::checkJsonStatus');
    $routes->cli('pushcbreporttomagento', 'SendPdftoMagento::pushCbReporttoMagento');
    $routes->cli('cbarchivejsonandreports', 'ArchiveDearchiveFiles::cbArchiveJsonFilesandReports');
    $routes->cli('cbfailedreport', 'EmailController::cbFailedReport');
    $routes->cli('cbtestgroupduplicatenotification', 'EmailController::cbTestGroupDuplicateNotification');
    $routes->cli('pushcbreporttostemcell', 'SendpdftoStemcell::pushCbReporttoStemcell');
    /** CB REPORT CRON END */

	
	 /** STD REPORT CRON */
    $routes->cli('generatestdreport', 'StdController::index');
    $routes->cli('pushstdreporttomagento', 'SendPdftoMagento::pushStdReporttoMagento');
    $routes->cli('stdmhqupdate', 'StdController::updateMHQ');
    /** STD REPORT CRON */

    
    /** OVASCORE REPORT CRON */
    $routes->cli('generateovascorereport', 'OvaScoreController::index');
    $routes->cli('ovascorefailedreport', 'EmailController::ovascorefailedreport');
    $routes->cli('ovascorependingemailalert', 'EmailController::ovascorependingemailalert');
    $routes->cli('pushovascorereporttomagento', 'SendPdftoMagento::pushOvascoreReporttoMagento');
    /** OVASCORE REPORT CRON */

    /** PERIMENOPAUSE REPORT CRON */
    $routes->cli('generateperimenopausereport', 'PerimenopauseController::index');
    $routes->cli('perimenopausefailedreport', 'EmailController::perimenopausefailedreport');
    $routes->cli('perimenopausependingemailalert', 'EmailController::perimenopausependingemailalert');
    $routes->cli('pushperimenoreporttomagento', 'SendPdftoMagento::pushPerimenoReporttoMagento');
    /** PERIMENOPAUSE REPORT CRON */

    /**ANNUAL STEM MATCH  REPORT CRON START */
    $routes->cli('generateannualstemmatchreport', 'AnnualStemMatchController::index');
    $routes->cli('pushannualstemmatchtomagento', 'SendPdftoMagento::pushAnnualStemMatchtoMagento');
    /**ANNUAL STEM MATCH  REPORT CRON END */

    /**PHARMACOGENOMICS  REPORT CRON START */
    $routes->cli('generatepharmacogenereport', 'PharmaCoGenomicsController::index');
    //$routes->cli('pushpharmacogenomicstomagento', 'SendPdftoMagento::pushPharmaCoGenomicstoMagento');
    $routes->cli('pushpharmacogenereporttolims', 'SendPdftoLims::pushPharmacogenegeporttoLims');
    /**PHARMACOGENOMICS  REPORT CRON END */

  
});




$routes->resource('config', [
    'filter'     => 'permission:manage-user',
    'namespace'  => 'App\Controllers\Users',
    'controller' => 'ConfigController',
    'except'     => 'show',
]);
/**
 * view as a html routes.
 **/

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to ma ke that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
