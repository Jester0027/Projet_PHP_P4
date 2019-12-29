M.AutoInit();

const preloader = '<div class="preloader-wrapper big active loader"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';

$(function () {
    console.log('👍 dom ready');

    const getData = (route, id) => {
        $("#articles").html('');
        $("#users").html('');
        $("#reports").html('');
        $(id).html(preloader);
        $.ajax({
            url: 'index.php?route=' + route,
            type: 'GET',
            dataType: 'html',
            success: function (res, status) {
                console.log(status + " 👍");
                $(id).html(res);
            },
            error: function (res, status, err) {
                console.log(status + "'s Response 👉 " + res);
                console.log("Error 👉 " + err);
                $(id).html('<p class="red-text">Erreur lors de la requete</p><p class="red-text">' + res.status + ' ' + res.statusText + '</p>');
            },
            complete: function (res, status) {
                console.log(status + " response 👇 ");
                console.dir(res);
            }
        });
    }

    const getArticles = function () { getData("_adminArticles", "#articles") }
    const getUsers = function () { getData("_adminUsers", "#users") }
    const getReportedComments = function () { getData("_adminReports", "#reports") }

    getArticles();

    $('#articlesSelector').on('click', getArticles);
    $('#usersSelector').on('click', getUsers);
    $('#reportsSelector').on('click', getReportedComments);
});