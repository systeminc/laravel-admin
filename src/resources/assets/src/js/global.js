Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function empty(v){
	return !v || typeof v == 'undefined' || ( typeof v == 'string' && v.replace(/[0| ]+/gm,'')==='' )	|| ( typeof v == 'object' && !Object.size(v) );
}

Number.prototype.numberFormat = function(c, d, t){
var n = this,
    c = isNaN(c = Math.abs(c)) ? 2 : c,
    d = d == undefined ? "." : d,
    t = t == undefined ? "," : t,
    s = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(c), 10) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

var _isMacLike = navigator.platform.match(/(Mac|iPhone|iPod|iPad)/i)?true:false;
var _isIOS = navigator.platform.match(/(iPhone|iPod|iPad)/i)?true:false;

function monthDiff(d1, d2) {
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth() + 1;
    months += d2.getMonth();
    return months <= 0 ? 0 : months;
}

jQuery(function($){

    $.fn.serializeObject = function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
    
})

var blueMapStyle = [
    {
        "featureType": "landscape",
        "stylers": [ 
            { "color": "#003279" }
        ]
    },{
        "featureType": "poi",
        "stylers": [
            { "color": "#003279" }
        ]
    },{
        "featureType": "administrative",
        "elementType": "geometry",
        "stylers": [
            { "color": "#003279" }
        ]
    },{
        "featureType": "administrative",
        "elementType": "labels.text",
        "stylers": [
            { "invert_lightness": true },
            { "visibility": "simplified" }
        ]
    },{
        "featureType": "administrative.country",
        "stylers": [
            { "visibility": "off" }
        ]
    },{
        "featureType": "administrative.province",
        "elementType": "labels",
        "stylers": [
            { "visibility": "off" }
        ]
    },{
        "featureType": "road",
        "stylers": [
            { "visibility": "simplified" },
            { "lightness": 30 },
            { "color": "#86acda" },
            { "saturation": -100 }
        ]
    },{
        "featureType": "transit",
        "elementType": "geometry",
        "stylers": [
            { "visibility": "off" }
        ]
    } 
];
jQuery(document).ready(function($) {
    $(document).keydown(function(e) {
        var key = undefined;
        var possible = [ e.key, e.keyIdentifier, e.keyCode, e.which ];

        while (key === undefined && possible.length > 0)
        {
            key = possible.pop();
        }

        if (key && (key == '115' || key == '83' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
        {
            e.preventDefault();
            $(':focus').closest('form').submit();
            
            return false;
        }
        return true;
    });
});