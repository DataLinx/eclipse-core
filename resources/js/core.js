import './bootstrap';
import {Toast} from 'bootstrap';

/*
$('.user-delete').click(function(){
    if (confirm('Are you sure you want to delete this user?')) {
        var $row = $(this).closest('tr');
        $.ajax('/users/'+ $(this).data('id'), {
            method: 'delete',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(data) {
                if ( ! data.error) {
                    $row.remove();
                }
            }
        })
    }
});
*/

_.forEach(document.getElementsByClassName('toast'), function(element) {
    const toast = new Toast(element);
    toast.show();
});
