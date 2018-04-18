$(function() {
	//==============
    // ATTRIBUTES
    //==============
    var DATE_RANGE_DATE_FORMAT = "MMM D, YYYY";
    var REQ_DATE_FORMAT = "YYYY-MM-DD";
    var DEFAULT_DATE_RANGE_PERIOD = 6; // Last 7 days
    var startDate = moment().subtract(DEFAULT_DATE_RANGE_PERIOD, 'days');
    var endDate = moment();
    var selectedUsers = "";
    var totalUsers = 0;
    var totalWorkingLogs = 0;   
    var avgWorkingLogsPerUser = 0; 
    var avgUsersPersDay =0;
    var avgWorkingLogsPerDay = 0;
    var urlWorkingLogData = '/admin/dashboards/working_log_data';
    var workingLogs = [];
    var summaryData = [];
    var summaryDataHashByDate = {};
    var listDate = [];

    var pathCheckInOutResource = "/check-in-out/";
    var path_default_image = '/images/';

	//==============
    // FILTERS
    //==============
    //---> SELECT2 USERS
    $("#filter-users").select2({
    	placeholder: "--All Users--",
    	allowClear: false,
    	multiple: true,    	
    	width: '100%'
    	// data: [{id: 0, text: 'story'},{id: 1, text: 'bug'},{id: 2, text: 'task'}]
    	// matcher: function(term, text) { 
    	// 	return text.toUpperCase().indexOf(term.toUpperCase())==0; 
    	// }
    });
    //$('#filter-users').select2("val", '');
    $('#filter-users').val([]).trigger('change');

	//---> DATE RANGE
    function cb(start, end) {
        $('#filter-daterange span').html(start.format(DATE_RANGE_DATE_FORMAT) + ' - ' + end.format(DATE_RANGE_DATE_FORMAT));
    }
    $('#filter-daterange').daterangepicker({
        startDate: startDate,
        endDate: endDate,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);
    cb(startDate, endDate);   

	//==============
    // CHART
    //==============
    var charCtx = document.getElementById('chart').getContext('2d');
    var generateDateLabelsForChart = function(startDate, stopDate){
    	var dateArray = new Array();
	    var currentDate = startDate;
	    while (currentDate <= stopDate) {
	        //dateArray.push(new Date (currentDate));
	        //currentDate = currentDate.addDays(1);
	        dateArray.push(currentDate.format('MMM D, YYYY'));
	        currentDate = currentDate.add(1,'days');
	    }
	    return dateArray;

    }
    var chartData =  {
	    //labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
	    labels: [],//generateDateLabelsForChart(moment().subtract(9, 'days'),moment()),
	    datasets: [{ 
	        data: [],//[86,114,106,106,107,111,133,221,783,2478],
	        label: "Users",
	        borderColor: "#3e95cd",
	        fill: true
	      }, { 
	        data: [],//[282,350,411,502,635,809,947,1402,3700,5267],
	        label: "Working Logs",
	        borderColor: "#8e5ea2",
	        fill: true
	      }
	    ]
	  };
	var chartOptions = {
	  	//---> Responsive
      	responsive: true,
      	maintainAspectRatio: false,
      	//---> Title      
	    title: {
	      display: false,
	      text: 'Check In/Out Trending'
	    },
	    //---> Scale
	    scales: {
		    xAxes: [{
		                gridLines: {
		                    display:false
		                }
		            }],
		    yAxes: [{
		                gridLines: {
		                    display:false
		                }   
		            }]
		},
	    //---> Tooltip
	    tooltips: {
	    	"mode": "x-axis",
			"callbacks": {},
	    	intersect: true,

	    }

	  };
    var chart = new Chart(charCtx, {
	  type: 'line',
	  data: chartData,
	  options: chartOptions
	});

    function refreshChartData(){
    	//---> Prepare date range       	
    	listDate = listDateFromDateRange(startDate, endDate);    	
    	//---> Reset
    	chart.data.labels = [];
		chart.data.datasets[0].data = [];
		chart.data.datasets[1].data = [];
    	//---> New Data
    	/*summaryData.forEach (function(item){    		
    		//chart.data.labels.push(moment(item.date,REQ_DATE_FORMAT).format(DATE_RANGE_DATE_FORMAT));
    		chart.data.labels.push(item.date);
    		chart.data.datasets[0].data.push(item.user_cnt);
    		chart.data.datasets[1].data.push(item.working_log_cnt);
    	});*/
		listDate.forEach (function(date){ 
			var dateString = date.format(REQ_DATE_FORMAT); 
			//console.log(date); console.log(dateString);
			var summaryItem = summaryDataHashByDate[dateString];
			var userCount = 0;
			var workingLogCount = 0;
			if (summaryItem){
				userCount = summaryItem.user_cnt;
				workingLogCount = summaryItem.working_log_cnt;
			}
			chart.data.labels.push(dateString);
			chart.data.datasets[0].data.push(userCount);
			chart.data.datasets[1].data.push(workingLogCount);
		});

    	chart.update();
    }    

    //==============
    // SUMMARY
    //==============
    function processSummaryData(){
    	var tempUserCount = 0;
    	var dayCount = listDate.length;
    	//---> Total Working Logs
    	totalWorkingLogs = 0;    	
    	summaryData.forEach(function(item){
    		totalWorkingLogs += item.working_log_cnt;
    		tempUserCount += item.user_cnt;
    	});
    	//---> Total Users
    	totalUsers = new Set(workingLogs.map(function(item){
    		return item.user_id;
    	})).size;
    	//---> Average Working Logs / User
    	avgWorkingLogsPerUser = totalUsers > 0 ? parseFloat(totalWorkingLogs)/totalUsers : 0;
    	//---> Average Working Logs / Day
    	avgWorkingLogsPerDay = dayCount > 0 ? parseFloat(totalWorkingLogs)/dayCount : 0;
    	//---> Average Users / Day
    	avgUsersPerDay = dayCount > 0 ? parseFloat(tempUserCount)/dayCount : 0;

    	//---> Update UI
    	$("#summary-total-users").text(totalUsers);
    	$("#summary-total-working-logs").text(totalWorkingLogs);
    	$("#summary-avg-working-logs-per-user").text(avgWorkingLogsPerUser.toFixed(2));
    	$("#summary-avg-working-logs-per-day").text(avgWorkingLogsPerDay.toFixed(2));
    	$("#summary-avg-users-per-day").text(avgUsersPerDay.toFixed(2));
    }

    //==============
    // TABLE 
    //==============
    function configureDataTable(){

        $("#table-working-log").DataTable({
            responsive: true,
            ordering: true,
            searching: false,
            responsive: true,
            filter: false,
            paging: true,
            info: false,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "columnDefs": [
              { "width": "70px", "targets": 3 },
              { "width": "70px", "targets": 6 },
            ],
            columns: [
                { "data": null, render: function (data, type, row, full) {
                        full.row = full.row + 1;
                        return '<span>'+full.row+'</span>'; 
                    }
                },
                { "data": null, render: function (data, type, row, full) {
                        var text ="";
                        text= data["user"]["first_name"]+' '+data["user"]["last_name"];                        
                        return text; 
                    }
                },
                { "data": null, render: function (data, type, row) {
                        var text ="";
                        if (data.check_in_at != null ) {
                            text = '<span class="c-check-at">'+data.check_in_at+" UTC"+'</span>';
                            text += '<br/><span class="c-internet-quality label label-default"><i class="fa fa-signal"></i> '+ FDTNetworkUtil.markToRating(data['check_in_internet_quality']) + '</span>';
                        }else{
                            text = '';
                        }
                        return text; 
                    }
                },
                { "data": null, render: function (data, type, row, full) {
                        var text ="";
                        var rowId = full.row + 1;
                        if(data.check_in_photo != null && data.check_in_photo.length >0){
                            //text = '<img class="c-check-photo" src="' + pathCheckInOutResource + data.check_in_photo + '" style="object-fit: cover;" width="50" height="50"/>';
                            text = '<img id="img-check-in-'+rowId+'" onclick="displayImageModal(this.id);" class="c-check-photo" src="' + pathCheckInOutResource + data.check_in_photo + '" style="object-fit: cover; cursor:pointer;" width="50" height="50"/>';
                        }else{
                            //text = '<img iclass="c-check-photo" src="' + path_default_image + 'default_avatar_male.jpg" style="object-fit: cover;" width="50" height="50"/>';
                        }
                        return text; 
                    }
                },
                { "data": null, render: function (data, type, row) {
                        var text ="";
                        if(data.check_in_voice != null && data.check_in_voice.length >0){
                            text = '<a class="c-voice" href="javascript:;" data="'+ pathCheckInOutResource + data.check_in_voice+'" onclick="playVoice(this);">'
                            +'<i class="fa fa-play-circle" aria-hidden="true"></i>'
                            +'</a>';
                        }
                        return text; 
                    }
                },
                { "data": null, render: function (data, type, row) {
                    var text ="";
                    if (data.check_out_at != null) {
                        text = '<span class="c-check-at">'+data.check_out_at+" UTC"+'</span>';
                        text += '<br/><span class="c-internet-quality label label-default"><i class="fa fa-signal"></i> '+ FDTNetworkUtil.markToRating(data['check_out_internet_quality']) + '</span>';
                    }else{
                        text = '';
                    }
                    return text; 
                }
                },
                { "data": null, render: function (data, type, row, full) {
                    var text ="";
                    var rowId = full.row + 1;
                    if(data.check_out_photo != null  && data.check_out_photo.length >0){
                        //text = '<img class="c-check-photo" src="' + pathCheckInOutResource + data.check_out_photo + '" style="object-fit: cover;" width="50" height="50"/>';
                        text = '<img id="img-check-in-'+rowId+'" onclick="displayImageModal(this.id);" class="c-check-photo" src="' + pathCheckInOutResource + data.check_out_photo + '" style="object-fit: cover; cursor:pointer;" width="50" height="50"/>';
                    }else{
                        //text = '<img class="c-check-photo" src="' + path_default_image + 'default_avatar_male.jpg" style="object-fit: cover;" width="50" height="50"/>';
                    }
                    return text; 
                }
                },
                { "data": null, render: function (data, type, row) {
                    var text ="";
                    if(data.check_out_voice != null && data.check_out_voice.length >0){
                        text = '<a class="c-voice" href="javascript:;" data="'+ pathCheckInOutResource + data.check_out_voice+'" onclick="playVoice(this);">'
                        +'<i class="fa fa-play-circle" aria-hidden="true"></i>'
                        +'</a>';
                    }
                    return text; 
                }
                },
            ],
        });

        $('.dataTables_wrapper .row:last .col-sm-5').prepend($('#table-working-log_length'));       
    }

    function processDataTable(){
        $('#table-working-log').dataTable().fnClearTable();
        $('#table-working-log').dataTable().fnAddData(workingLogs);
    }

	//==============
    // ACTIONS
    //==============
    $("#btn-update").click(function(){
   		loadDataByFilter();
    });
    $("#btn-export-csv").click(function(){
        var siteOrigin = window.location.origin;
        //alert("This function is under development");
        var fileName = getExportFileName("csv");
        var csvString = '';
        var headers = ["SN", "User", "In-At","In-Photo", "In-Voice", "Out-At","Out-Photo", "Out-Voice"];        
        //---> Header
        for(var i=0; i<headers.length;i++){            
            csvString = csvString + headers[i] + ",";
        }
        csvString = csvString + "\n";

        //---> Data
        for(var i=0; i<workingLogs.length;i++){
            var sn = i+1;
            var rowData = workingLogs[i];
            var userName = rowData["user"]["first_name"]+' '+rowData["user"]["last_name"];
            var checkInAt = rowData["check_in_at"];
            var checkInPhotoUrl = siteOrigin + "/"+pathCheckInOutResource+rowData["check_in_photo"];
            var checkInVoiceUrl = "";
                if( rowData["check_out_voice"] != null && rowData["check_in_voice"].length > 0) {
                    checkInVoiceUrl = siteOrigin + "/"+pathCheckInOutResource+rowData["check_in_voice"];
                }
            var checkOutAt = "";
                if(rowData["check_out_at"] != null){
                    checkOutAt = rowData["check_out_at"];
                }            
            var checkOutPhotoUrl = siteOrigin + "/"+pathCheckInOutResource+rowData["check_out_photo"];
            var checkOutVoiceUrl = "";
                if( rowData["check_out_voice"] != null && rowData["check_out_voice"].length > 0) {
                    checkOutVoiceUrl = siteOrigin + "/"+pathCheckInOutResource+rowData["check_out_voice"];
                }
            csvString = csvString + sn + ",";            
            csvString = csvString + userName + ",";
            csvString = csvString + checkInAt + ",";
            csvString = csvString + checkInPhotoUrl + ",";
            csvString = csvString + checkInVoiceUrl + ",";
            csvString = csvString + checkOutAt + ",";
            csvString = csvString + checkOutPhotoUrl + ",";
            csvString = csvString + checkOutVoiceUrl + ",";

            csvString = csvString + "\n";
        }
        csvString = csvString.substring(0, csvString.length - 1);
        var a = $('<a/>', {
            style:'display:none',
            href:'data:application/octet-stream;base64,'+btoa(csvString),
            download: fileName
        }).appendTo('body')
        a[0].click()
        a.remove();
    });
    $("#btn-export-pdf").click(function(){
        //alert("PDF");
        var fileName = getExportFileName("pdf");
        var siteOrigin = window.location.origin; 
        //var doc = new jsPDF('p', 'pt', [1190, 842]); //(orientation, unit, format, compress);
        var doc = new jsPDF('p', 'pt', 'a3');
        var headers = ["SN", "User", "In-At","In-Photo", "In-Voice", "Out-At","Out-Photo", "Out-Voice"];  
        var rows = [];
        for(var i=0; i<workingLogs.length;i++){
            var sn = i+1;
            var rowData = workingLogs[i];
            var userName = rowData["user"]["first_name"]+' '+rowData["user"]["last_name"];
            var checkInAt = rowData["check_in_at"];
            var checkInPhotoUrl = siteOrigin +pathCheckInOutResource+rowData["check_in_photo"];
            var checkInVoiceUrl = "";
                if( rowData["check_out_voice"] != null && rowData["check_in_voice"].length > 0) {
                    //checkInVoiceUrl = '<a  href="' +siteOrigin +pathCheckInOutResource+rowData["check_in_voice"] +'">link</a>';
                    checkInVoiceUrl = siteOrigin +pathCheckInOutResource+rowData["check_in_voice"];
                }
            var checkOutAt = "";
                if(rowData["check_out_at"] != null){
                    checkOutAt = rowData["check_out_at"];
                }            
            var checkOutPhotoUrl = siteOrigin +pathCheckInOutResource+rowData["check_out_photo"];
            var checkOutVoiceUrl = "";
                if( rowData["check_out_voice"] != null && rowData["check_out_voice"].length > 0) {
                    checkOutVoiceUrl = siteOrigin +pathCheckInOutResource+rowData["check_out_voice"];
                }
            var rowItem = [sn, userName, checkInAt, checkInPhotoUrl, checkInVoiceUrl, checkOutAt,checkOutPhotoUrl,checkOutVoiceUrl]
            rows.push(rowItem);            
        }
        doc.autoTable(headers, rows,{   
            orientation: "L",
            // Styling
            theme: 'striped', // 'striped', 'grid' or 'plain'
            styles: {
                overflow: 'linebreak',
                columnWidth: 'auto'
            },
            headerStyles: {},
            bodyStyles: {},
            alternateRowStyles: {},
            columnStyles: {
                0: {columnWidth: 30},
                7: {columnWidth: 60}
            },

            // Properties
            startY: false, // false (indicates margin top value) or a number
            margin: 40, // a number, array or object
            pageBreak: 'auto', // 'auto', 'avoid' or 'always'
            tableWidth: 'auto', // 'auto', 'wrap' or a number, 
            showHeader: 'everyPage', // 'everyPage', 'firstPage', 'never',
            tableLineColor: 200, // number, array (see color section below)
            tableLineWidth: 0,
        });
        doc.save(fileName);

       /*var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#table-working-log')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF 
            //          this allow the insertion of new lines after html
            pdf.save('Test.pdf');
        }, margins);*/
    });

    //==============
    // REQUESTS
    //==============
    function loadDataByFilter(){
    	parseStartEndDateFromPicker();

   		parseSelectedUsersFromOptions();   		
   		//console.log(selectedUsers);
   		var requestData = {
   			user_ids: selectedUsers,
   			start_date: startDate.format(REQ_DATE_FORMAT),
   			end_date: endDate.format(REQ_DATE_FORMAT)
   		}
        showLoadingIndicator();
   		jQuery.ajax({
   			type: "GET",
   			url: urlWorkingLogData,
   			data: requestData
   		}).done(function(data) {
	    	//console.log( "success" );
	    	//console.log(data);
	    	// Process Data
	    	workingLogs =  data.items;
	    	summaryData = data.summary_items;
	    	summaryDataHashByDate = {};
	    	summaryData.forEach(function(item){
	    		summaryDataHashByDate[item.date] = item;
	    	});
	    	// Update Data table
            processDataTable();
	    	// Update Chart
	    	refreshChartData();
	    	// Update Summary
	    	processSummaryData();
	  	})
	  	.fail(function(data) {
	    	//console.log( "error" );
	    	//console.log(data);
	    	swal(			 
				  {
				  	title: 'Service is unavailable at this time',
				  	text: "Please try again later",
				  	type: "error",
	  				}
				);
	  	})
	  	.always(function(data) {
	  		hideLoadingIndicator();
	  	});
	}
    //==============
    // UTILS
    //==============
    //---> Parse start/end date from DateRange Picker
    function parseStartEndDateFromPicker(){
    	var start = $("#filter-daterange").data('daterangepicker').startDate;
    	var end = $("#filter-daterange").data('daterangepicker').endDate;
    	startDate = moment(start,DATE_RANGE_DATE_FORMAT);
    	endDate= moment(end,DATE_RANGE_DATE_FORMAT);
    }
    //---> Parse Selected Users from Select2
    function parseSelectedUsersFromOptions(){
    	var selectItems = $('#filter-users').select2('data');
    	/*var length = selectItems.length;
    	var idx = 1;
    	selectedUsers = "";
    	
    	selectItems.forEach(function(item){
    		selectedUsers += item["id"];
    		if (idx < length) selectedUsers += "|";
    	});*/
		selectedUsers = selectItems.map(function(item){
			return item.id;
		}).join("|");
    	
    }
	//---> Internet
   	function parseValueInternet(){
		elm = $('.c-internet-quality-mark');
		checkPoint = elm.text();
		elm.html(FDTNetworkUtil.markToRating(parseInt(checkPoint)));
	}
	//---> List Date from Date Range
	function listDateFromDateRange(startDate,stopDate){
		var dateArray = new Array();
	    var currentDate = startDate;
	    while (currentDate <= stopDate) {	    	
	        dateArray.push(moment(currentDate));
	        currentDate = currentDate.add(1,'days');
	    }
	    return dateArray;
	}

    //---> Show Loading Indicator
    function showLoadingIndicator(){
        $(".dashboard-working-log .overlay").css("display", "block");
    }

    //---> Hide Loading Indicator
    function hideLoadingIndicator(){
        $(".dashboard-working-log .overlay").css("display", "none");
    }  

    //---> Export filename
    function getExportFileName (extension){
        var fileName = "working_logs"+"_"+startDate.format(REQ_DATE_FORMAT)+"_to_"+endDate.format(REQ_DATE_FORMAT)+"."+extension;
        return fileName;
    }  

    //==============
    // DOCUMENT READY
    //==============
	$(document).ready(function(){	
		parseValueInternet();
		loadDataByFilter();
        configureDataTable();
	});
});

//==============
// MEDIA PLAYER
//==============
var audioElement;
function playVoice(elm){
    lastElm = elm;
    if (audioElement != undefined) {
        if (audioElement.duration > 0 && !audioElement.paused) {//---> Stop audio is playing
            audioElement.pause();
            $('.c-voice').attr('onclick','playVoice(this);');
            $('.c-voice').html('<i class="fa fa-play-circle" aria-hidden="true"></i>');
        }
    }
    //---> Create new audio and run it
    audioElement = document.createElement('audio');
    audioElement.setAttribute('src', elm.getAttribute('data'));
    audioElement.play();
    $(elm).html('<i class="fa fa-stop-circle-o" aria-hidden="true"></i>');
    $(elm).attr('onclick','stopVoice(this);');
    audioElement.addEventListener('ended', function() {
        stopVoice(elm);
    }, false);
}

function stopVoice(elm){
    audioElement.pause();
    $(elm).attr('onclick','playVoice(this);');
    $(elm).html('<i class="fa fa-play-circle" aria-hidden="true"></i>');
}

function displayImageModal(elmId){
    //---> BEGIN: Handle modal show full image
    // Get the modal
    var modal = document.getElementById('modalImageView');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById(elmId);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = img.src;
    //captionText.innerHTML = userData.first_name+' '+userData.last_name;

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
        modal.style.display = "none";
    }
    modalImg.onclick = function() { 
        modal.style.display = "none";
    }
    //---> END: Handle modal show full Image
}
