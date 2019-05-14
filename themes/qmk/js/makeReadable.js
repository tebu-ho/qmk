function makeReadable() {
    $('.card-body').find('.user-profile').removeAttr('readonly');
    $('.edit-profile').addClass('cancel').html('Cancel');
}
