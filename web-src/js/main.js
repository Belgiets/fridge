$(function () {
  $(document).ready(function () {
    /**
     * Additional forms on Item main form
     */
    /* Display forms*/
    var btnAddNew = $('.btn-add-new');
    if (btnAddNew) {
      btnAddNew.on('click', function(e) {
        e.preventDefault();

        var dataTargetForm = $(this).attr('data-form'),
          targetForm = $('.' + dataTargetForm);

        targetForm.slideToggle();
      });
    }

    /* Custom forms submit */

  });
});