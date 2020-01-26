M.AutoInit();

document.addEventListener('DOMContentLoaded', function() {
    tinymce.init({
        selector: '.tinymce'
    });
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems, {});

    const sessionMessage = document.querySelector('#session');
    if(sessionMessage && sessionMessage.textContent.trim() !== '') {
        M.toast({html: '<p>'+ sessionMessage.textContent.trim() +'</p>'});
    }
});
