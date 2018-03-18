<?php

function export_users_page() {
    $users_query = new WP_User_Query( array(
        'role__in' => array('Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber'),
        'exclude' => array(1)
    ) );

    $users = $users_query->get_results();

    $fp = fopen('php://memory', 'w+');
    if ($fp && $users) {
        $headerPresent = false;
        foreach ($users as $u) {
            $user = array(
                'username' => $u->get('user_login'),
                'email' => $u->get('user_email'),
                'nome' => $u->get('first_name'),
                'cognome' => $u->get('last_name'),

                'residenza' => $u->get('residenza'),
                'telefono' => $u->get('telefono'),
                'nato_a' => $u->get('nato_a'),
                'nato_il' => date_format(date_create_from_format('Ymd', $u->get('nato_il')), 'd-m-Y'),
                'codice_fiscale' => $u->get('codice_fiscale'),
                'data_registrazione' => date_format(date_create_from_format('Ymd', $u->get('data_registrazione')), 'd-m-Y'),
                'numero_tessera' => $u->get('numero_tessera'),
                'scadenza_tessera' => date_format(date_create_from_format('Ymd', $u->get('scadenza_tessera')), 'd-m-Y'),
            );

            if (!$headerPresent) {
                fputcsv($fp, array_keys($user));
                $headerPresent = true;
            }
            
            fputcsv($fp, $user);
        }
    }
    
    fseek($fp, 0);
    
    $csv_content = stream_get_contents($fp);
    $records = count($users);
    
    print("<textarea id='csv_content' class='hidden'>$csv_content</textarea>");
    print('<h1>Estrazione utenti completata!</h1>');
    print("<p>Nel csv sono presenti i dati dei <b>$records</b> utenti immessi nel sistema.</p>");
?>
    <a id="download_button" class="button button-primary">Scarica CSV</a>
    <script>
        var content = document.getElementById('csv_content').value
        var content_blob = new Blob([content], {type: 'text/csv'})
        var url = URL.createObjectURL(content_blob)
        var date = new Date()
        var formatted_date = date.toISOString().split('T')[0]
        var link = document.getElementById('download_button')
        link.setAttribute('href', url);
        link.setAttribute('download', 'utenti-fablab-' + formatted_date + '.csv');
    </script>
<?php
}

function menu_export_users() {
	add_users_page('Esporta in CSV', 'Esporta in CSV', 'list_users', 'export-users-to-csv', 'export_users_page');
}


class misc {

    static function add_users_export_button() {
        add_action('admin_menu', 'menu_export_users');
    }
}
