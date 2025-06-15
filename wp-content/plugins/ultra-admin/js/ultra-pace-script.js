/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */


/*----------------------------------
    Page loader
-----------------------------------*/

(function($) {
    Pace.on('start', function(){
    });
    Pace.on('hide', function(){
    	$("#wpwrap").addClass("loaded");
    });
 })(jQuery);
 
