$(function(){
    user = {};

    user.run = function(){
        user.list_loader();
    };

    user.list_loader = function(){
        var url = base_url + 'user/api_read_user_list';
        var data = {};
        console.log(url);
        $.post(
            url,
            data,
            function(users) {
                console.log(users);
                user.list_table_maker(users);
            },
            "json"
        );
    };

    user.list_table_maker = function(users){
        var tbody = '';
        var row   = '';
        var user  = '';

        for (var key in users) {
            user = users[key];

            user.name = '<a href="' + base_url + 'user/user_info/' + user.name + '">' + user.name + '</a>';

            var provider_row = '';
            for (var key2 in user.providers) {
                var provider = user.providers[key2];
                provider_row += '<span class="label label-primary">' + provider[0] +'/' + provider[1] + '</span> ';
            }


            row = '<tr>';
            row += '<td>' + user.id + '</td>';
            row += '<td>' + user.name + '</td>';
            row += '<td>' + user.status + '</td>';
            row += '<td>' + user.created + '</td>';
            row += '<td>' + provider_row + '</td>';

            tbody += row;
        }

        $('#user_list tbody').html(tbody);
    };

    user.run();

});