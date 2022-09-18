const D = new DOM( );

const new_button = D.query('.new');
new_button.addEventListener('click', modal_new_file);


const file_info = D.query('.file-info');
file_info.addEventListener('click', toggle_file_info);

const avatar_usuario = D.query('#user-config > a');
avatar_usuario.addEventListener('click', modal_usuario);

const set_darkmode = D.query('.darkmode');
set_darkmode.addEventListener('click', toggle_darkmode);

const menu_open = D.id('menu-open');
menu_open.addEventListener('click', open_nav);

const menu_close = D.query('.nav-header-close');
menu_close.addEventListener('click', close_nav);

window.addEventListener('keydown', escuchar_tecla);
document.body.addEventListener('click', click_eliminar_modales);

const file_toggles = D.query('.toggle');
file_toggles.addEventListener('click', toggle_grid);

const btn_avanzado = D.id('btn-avanzado');
btn_avanzado.addEventListener('click', show_busqueda_avanzada ); 


const btn_cerrar_avanzado = D.id('cerrar-avanzado');
btn_cerrar_avanzado.addEventListener('click', hide_busqueda_avanzada ); 



scannear_items( );