var FDTImageUtil = function(){
	var dataURItoBlob2 = function dataURItoBlob2(dataURI) {
	    // convert base64/URLEncoded data component to raw binary data held in a string
	    var byteString;
	    if (dataURI.split(',')[0].indexOf('base64') >= 0)
	        byteString = atob(dataURI.split(',')[1]);
	    else
	        byteString = unescape(dataURI.split(',')[1]);

	    // separate out the mime component
	    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

	    // write the bytes of the string to a typed array
	    var ia = new Uint8Array(byteString.length);
	    for (var i = 0; i < byteString.length; i++) {
	        ia[i] = byteString.charCodeAt(i);
	    }

	    return new Blob([ia], {type:mimeString});
	}

	var dataURItoBlob = function (dataURI) {
	    var byteString = atob(dataURI.split(',')[1]);
	    var ab = new ArrayBuffer(byteString.length);
	    var ia = new Uint8Array(ab);
	    for (var i = 0; i < byteString.length; i++) {
	        ia[i] = byteString.charCodeAt(i);
	    }
	    return new Blob([ab], { type: 'image/jpeg' });
	}
	return {
		dataURItoBlob: function(dataURI) {
			return dataURItoBlob(dataURI);
		}
	}
}(jQuery);


var FDTNetworkUtil = function(){
	return {
		markToRating: function(networkQualityMark) {
			//  poor, fair, good, very good, or excellent
			// poor, below average, average, good , excellent
			var POOR = "poor";
			var FAIR = "fair";
			var AVERAGE = "average";
			var GOOD = "good";
			var EXCELLENT = "excellent";
			var networkQualityText = 'N/A';
			var x = parseInt(networkQualityMark);
			switch (true) {
			    case (x> 0 && x < 2):
			        networkQualityText = POOR;
			        break;
			    case (x >=2 && x < 4):
			        networkQualityText = FAIR;
			        break;
			    case (x >=4 && x < 6):
			        networkQualityText = AVERAGE;
			        break;
			    case (x >=6 && x < 8):
			        networkQualityText = GOOD;
			        break;
			    case (x >=8):
			        networkQualityText = EXCELLENT;
			        break;
			    default:
			        
			        break;
			};
			
			return networkQualityText;
		}
	}
}(jQuery);