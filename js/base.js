 //toggles +/-   
  function toggleIcon(e) {
    jQuery(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
  }
  jQuery('.panel-group').on('hidden.bs.collapse', toggleIcon);
  jQuery('.panel-group').on('shown.bs.collapse', toggleIcon);

//expands via URL
 jQuery(document).ready(function() {
        if(window.location.hash != null && window.location.hash != ""){
          console.log(location.hash);
        jQuery('.collapse').removeClass('in');
        jQuery(window.location.hash + '.collapse').collapse('show');
      }
   });