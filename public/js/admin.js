M.AutoInit();

const preloader = `
    <div class="preloader-wrapper big active loader">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
`;

$(function() {
    console.log('👍 dom ready');

    const getArticles = function() {
        $('#articles').html(preloader);
        $.ajax({
            url: 'index.php?route=_adminArticles',
            type: 'GET',
            dataType: 'html',
            success: function(res, status) {
                console.log(status + " 👍");
                $('#articles').html(res);
            },
            error: function(res, status, err) {
                console.log(status + "'s Response 👉 " + res);
                console.log("Error 👉 " + err);
                $('#articles').html(`
                    <p class="red-text">Erreur lors de la requete</p>
                    <p class="red-text">${res.status} ${res.statusText}</p>
                `)
            },
            complete: function(res, status) {
                console.log(status + " response 👇 ");
                console.dir(res);
            }
        });
    }

    const getUsers = function() {
        $('#users').html(preloader);
        $.ajax({
            url: 'index.php?route=_adminUsers',
            type: 'GET',
            dataType: 'html',
            success: function(res, status) {
                console.log("Success 👍");
                $('#users').html(res);
            },
            error: function(res, status, err) {
                console.log(status + "'s Response 👉 " + res);
                console.log("Error 👉 " + err);
                $('#users').html(`
                    <p class="red-text">Erreur ajax</p>
                    <p class="red-text">${res.status} ${res.statusText}</p>
                `)
            },
            complete: function(res, status) {
                console.log(status + " response 👇 ");
                console.dir(res);
            }
        });
    }

    const getReportedComments = function() {
        $('#reports').html(preloader);
        $.ajax({
            url: 'index.php?route=_adminReports',
            type: 'GET',
            dataType: 'html',
            success: function(res, status) {
                console.log(status + " 👍");
                $('#reports').html(res);
            },
            error: function(res, status, err) {
                console.log(status + "'s Response 👉 " + res);
                console.log("Error 👉 " + err);
                $('#articles').html(`
                    <p class="red-text">Erreur ajax</p>
                    <p class="red-text">${res.status} ${res.statusText}</p>
                `)
            },
            complete: function(res, status) {
                console.log(status + " response 👇 ");
                console.dir(res);
            }
        });
    }

    getArticles();
    $('#articlesSelector').on('click', getArticles);
    $('#usersSelector').on('click', getUsers);
    $('#reportsSelector').on('click', getReportedComments);
});
