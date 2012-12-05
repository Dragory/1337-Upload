function toRGBA(val)
{
    // HEX VALUES
    if (val.substr(0, 1) == '#')
    {
        // Short way (e.g. #333)
        if (val.length == 4)
        {
            var temp = '#';
            for (var i = 1; i < val.length; i++)
            {
                temp += val[i]+val[i];
            }

            val = temp;
        }

        // If the format is now not e.g. #765432, let's not parse it
        if (val.length != 7) return 'rgba(0, 0, 0, 0)';

        // Handle the value
        var hR = val.substr(1, 2);
        var hG = val.substr(3, 2);
        var hB = val.substr(5, 2);

        var r = parseInt(hR, 16);
        var g = parseInt(hG, 16);
        var b = parseInt(hB, 16);
        
        return [r, g, b, 1];
    }

    // RGB(A) VALUES
    if (val.substr(0, 3) == 'rgb')
    {
        var matches = val.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+),?\s*(.*?)\)$/i);

        var r = matches[1];
        var g = matches[2];
        var b = matches[3];
        var a = 1;

        if (matches[4]) a = matches[4];

        return [r, g, b, a];
    }
}

(function() {
    var $headerElem = $('#header');

    setInterval(function() {
        return;
        
        // Get the current background color
        /*var col = $headerElem.css('background-color');
        var rgba = toRGBA(col);*/

        var time = (+new Date)/200;
        var rgba = [0, 0, 0, 1];
        rgba[0] = (Math.sin(time)+1)*127;
        rgba[1] = (Math.sin(time)+1)*127 + 60;
        rgba[2] = (Math.sin(time)+1)*127 + 120;

        /*rgba[0] = parseInt(rgba[0]) + Math.round(Math.random()*5);
        rgba[1] = parseInt(rgba[1]) + Math.round(Math.random()*5);
        rgba[2] = parseInt(rgba[2]) + Math.round(Math.random()*5);

        console.log(Math.atan2(Math.sqrt(3) * (rgba[1] - rgba[2]), 2 * rgba[1] - rgba[2] - rgba[3]));*/


        while (rgba[0] > 255) rgba[0] -= 255;
        while (rgba[1] > 255) rgba[1] -= 255;
        while (rgba[2] > 255) rgba[2] -= 255;

        rgba[0] = Math.round(rgba[0]);
        rgba[1] = Math.round(rgba[1]);
        rgba[2] = Math.round(rgba[2]);

        // console.log(rgba);

        $headerElem.css({'background-color': 'rgba(' + rgba[0] + ', ' + rgba[1] + ', ' + rgba[2] + ', ' + rgba[3] + ')'});
    }, 16);
})();