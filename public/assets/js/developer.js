$( function() {
  ns_developer = {};

  ns_developer.api_url = {};
  ns_developer.api_url.projects = './v1/res/projects';
  ns_developer.api_url.clients = './v1/res/clients';

  ns_developer.run = function() {
    ns_developer.tab_hash();
    ns_developer.get_projects();
  };

  ns_developer.tab_hash = function() {
    var hash = window.location.hash;
    hash && $( 'ul.nav a[href="' + hash + '"]' ).tab( 'show' );

    $( '.nav a' ).click( function( e ) {
      var
      scrollmem = $('body').scrollTop();

      $( this ).tab( 'show' );
      window.location.hash = this.hash;
      $( 'html, body' ).scrollTop( scrollmem );
    });
  };

  ns_developer.get_projects = function() {
    var
    url = ns_developer.api_url.projects;

    $.get( url, function( data ) {
      ns_developer.make_projects_list( data );
    })
    .done( function() {
      ns_developer.register_projects_listener();
    });
  };

  ns_developer.get_project = function( project_id ) {
    var
    url = ns_developer.api_url.projects + '/' + project_id;

    $.get( url, function( data ) {
      ns_developer.make_client_list( data );
    });
  };

  ns_developer.get_clients = function( project_id ) {
    var
    key,
    project_url = ns_developer.api_url.projects + '/' + project_id;
    client_url = ns_developer.api_url.clients;

    $.get( project_url, function( data ) {
      $( '#project_name' ).html( data.name );
      $( '#create_client_btn' ).attr( 'for', project_id );
      $( '#create_client_project_id' ).attr( 'value', project_id );
    });

    $.get( client_url, function( data ) {
      for ( key in data ) {
        if ( data[key].project_id != project_id ) {
          data.splice( key, 1 );
          console.log( 'del client!' );
        }
      }

      ns_developer.make_client_list( data );
    })
    .done( function() {
      ns_developer.register_clients_listener();
    });
  };

  ns_developer.make_projects_list = function( data ) {
    var
    key, tr, project, sort, link_tag,
    tbody = '';


    for ( key in data ) {
      project = data[key];
      sort = parseInt( key + 1 );

      project_link_tag = '<a href="' + ns_developer.api_url.projects + '/' + project.project_id + '/edit">';
      client_link_tag = '<a href="#projects" class="project_link" for="' + project.project_id + '">';

      tr = '<tr>';
      tr += '<td>' + sort + '</td>';
      tr += '<td>' + project_link_tag + project.name + '</a></td>';
      tr += '<td>' + client_link_tag + 'Client管理' + '</a></td>';
      tr += '<td>' + project.created_at + '</td>';
      tr += '</tr>';

      tbody += tr;
    }

    $( '#project_list_tbody' ).html( tbody );
  };

  ns_developer.make_client_list = function( data ) {
    var
    key, table, client,
    tables = '',
    table_top = '<table class="table table-bordered">',
    table_bottom = '</table><hr/>';

    for ( key in data ) {
      client = data[key];
      table = '<p>';
      table += '<strong>Client ID for web application</strong>';
      table += ' <a href="' + ns_developer.api_url.clients + '/' + client.client_id + '/edit">[ Edit ]</a>';
      table += ' <a href="' + ns_developer.api_url.clients + '/' + client.client_id + '" client_method="delete">[ Delete ]</a>';
      table += '</p>';

      table += table_top;
      table += '<tr><td>Client ID</td><td>' + client.client_key + '</td></tr>';
      table += '<tr><td>Client secret</td><td>' + client.client_secret + '</td></tr>';
      table += '<tr><td>Redirect URIs</td><td>' + client.redirect_uri + '</td></tr>';
      table += '<tr><td>Javascript Origins</td><td>' + client.from_uri + '</td></tr>';
      table += table_bottom;

      tables += table;
    }

    $( '#clients_table' ).html( tables );
  };

  ns_developer.register_projects_listener = function( data ) {
    $( '.project_link' ).click( function() {
      var
      project_id = $( this ).attr( 'for' );

      ns_developer.get_clients( project_id );

      $( '#project-list' ).addClass( 'hide' );
      $( '#project-clients' ).removeClass( 'hide' );

    });

    $( '#return_project_list' ).click( function() {
      $( '#project-clients' ).addClass( 'hide' );
      $( '#project-list' ).removeClass( 'hide' );
    });

    $( '#return_project_list' ).click( function() {
      $( '#project-clients' ).addClass( 'hide' );
      $( '#project-list' ).removeClass( 'hide' );
    });

    $( 'a[project_method="delete"' ).click( function() {
      var
      url = $( this ).attr( 'href' );

      event.preventDefault();

      $.ajax({
        url: url,
        type: 'DELETE',
        dataType: 'json'
      })
      .done( function() {
        ns_developer.get_projects();
      });
    });
  };

  ns_developer.register_clients_listener = function( data ) {
    $( 'a[client_method="delete"' ).click( function() {
      var
      url = $( this ).attr( 'href' );

      event.preventDefault();

      $.ajax({
        url: url,
        type: 'DELETE',
        dataType: 'json'
      })
      .done( function( data ) {
        ns_developer.get_clients( data.project_id );
      });
    });
  };


  ns_developer.run();
});
