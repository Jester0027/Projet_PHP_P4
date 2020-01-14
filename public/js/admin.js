const preloader = '<div class="preloader-wrapper big active loader"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';

$(function () {

    const getData = (route, id, action = '') => {
        /**
         * Route initialization
         * 
         */
        if(!action) {
            $('#selected')[0].innerText = route;
            $('#page')[0].innerText = 1;
            $('#pages')[0].innerText = $('#' + route)[0].innerText;
        }

        $("#articlesButtons").html('');
        $("#usersButtons").html('');
        $("#reportsButtons").html('');
        $("#articles").html('');
        $("#users").html('');
        $("#reports").html('');
        $(".pagination").css('display', 'none');
        $(id).html(preloader);
        
        let page = +($('#page')[0].innerText);
        let pageCount = +($('#pages')[0].innerText);
        if(action == 'next' && page < pageCount) page++;
        if(action == 'prev' && page > 1) page--;
        $('#page')[0].innerText = page;
        $.ajax({
            url: 'index.php?route=' + route + '&page=' + page,
            type: 'GET',
            dataType: 'html',
            success: function (res, status) {
                $(id).html(res);
                $(".pagination").css('display', 'block');
            },
            error: function (res, status, err) {
                $(id).html('<p class="red-text">Erreur lors de la requete</p><p class="red-text">' + res.status + ' ' + res.statusText + '</p>');
            },
            complete: function (res, status) {

            }
        });
    }

    const getArticles = function () { getData("_adminArticles", "#content") }
    let prev = function () { getData($('#selected')[0].innerText, "#content", 'prev') }
    let next = function () { getData($('#selected')[0].innerText, "#content", 'next') }

    const getUsers = function () { getData("_adminUsers", "#content") }

    const getReportedComments = function () { getData("_adminReports", "#content") }

    getArticles();

    $('#articlesSelector').on('click', getArticles);

    $('#usersSelector').on('click', getUsers);

    $('#reportsSelector').on('click', getReportedComments);

    $('#__next').on('click', next);
    $('#__prev').on('click', prev);

});