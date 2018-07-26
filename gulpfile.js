var elixir = require('laravel-elixir');
elixir(function(mix) {
    mix.sass('login_page.scss', 'public/css/login_page.css');
});
elixir(function(mix) {
    mix.sass('admin_panel.scss', 'public/css/admin_panel.css');
});