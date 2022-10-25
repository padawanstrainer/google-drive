let uploading_files = 0;
const D = new DOM( );
const _v = 'javascript:void(0)';
const arrayModales = [
  '.modal',
  '.floating-modal',
  '.modal-usuario',
  '.modal-aside'
];

const reloadFileList = ( ) => {
  const formato = D.query('.icon.toggle' ).classList.contains('tabla') ? 'tabla': 'grilla';
  populate_grid( formato );
}

const checkUploadComplete = ( ) => {
  if( uploading_files == 0 ){
    if( icono = D.id('modal-upload-close-icon') ){
      icono.classList.add('visible');
    }
    reloadFileList( );
  }
}

const modal_crear_carpeta = e =>{
  e.stopPropagation( );
  const params = new URLSearchParams(document.location.search);
  const folder = params.get("folder"); 

  const ventana = D.create('div', { className: 'modal' });
  const sub = D.create('form', { className: 'sub-modal', action: '/post-folder', method: 'post' });
  const titulo = D.create('h2', { innerHTML: 'Carpeta nueva' });
  const input = D.create('input', { type: 'text', name: 'carpeta', autofocus: true });
  const folder_input = D.create('input', { type: 'hidden', name: 'folder', value: folder } );

  const div = D.create('div', { className: 'modal-buttons' });
  const aceptar = D.create('button', { innerHTML: 'Crear', type: 'submit' });
  const cancelar = D.create('button', { innerHTML: 'Cancelar', type: 'button', onclick: function(e){
    ventana.remove( );
  } });

  D.append([cancelar, aceptar, folder_input], div);
  D.append([titulo, input, div], sub);
  D.append(sub, ventana);
  D.append(ventana);

  input.focus( );

  if( modal = D.query('.floating-modal' ) ){ D.remove(modal); }
};


const modal_subir_archivo = e =>{
  const file_input = D.create('input', { type: 'file', name: 'files[]', multiple: true, onchange: e => {
      let modal = D.query('.modal-uploads' );
      const plural = file_input.files.length > 1 ? 's' : '';

      if( ! modal ){
        modal = D.create('div', { className: 'modal-uploads'});
        D.append(modal);

        const div_titulo = D.create('div', { className: 'modal-titulo' } );
        const titulo = D.create('h2', { innerHTML: 'Subiendo archivo' + plural } );
        const cerrar = D.create('a', { id: 'modal-upload-close-icon', href: _v, innerHTML: 'x', onclick: function( ){ modal.remove( ); } } );
        D.append( [titulo, cerrar], div_titulo );
        D.append( div_titulo, modal );
      }
      const params = new URLSearchParams(document.location.search);
      const folder = params.get("folder"); 


      uploading_files += file_input.files.length;
  
      Array.from(file_input.files).forEach( f => {
        const FD = new FormData( );
        FD.append( 'archivo', f );
        FD.append( 'folder', folder );
        FD.append( 'lastM', f.lastModified );

        const div = D.create('div',{ className: 'uploading-file'});
        const nombre = D.create('span',{ innerHTML: f.name });
        const barra = D.create('span',{ className: 'uploading-progress' });
        const progreso = D.create('i');
        D.append(progreso, barra);
        D.append([nombre,barra], div);
        D.append(div, modal);
        const ajax = new XMLHttpRequest( );
        ajax.open( 'POST', '/post-uploads', true );
        ajax.upload.onprogress = e => {
          progreso.style.width = Math.ceil(e.loaded * 100 / e.total) + 'px';
        }
        ajax.onload = function( e ){
          uploading_files--;
          checkUploadComplete( );
          const rta = JSON.parse(ajax.responseText);
          if( ! rta.status ){
            nombre.style.color= 'red';
            nombre.title = rta.message;
            progreso.style.backgroundColor= 'red';
          }
        }
        ajax.send( FD );
      });
  } } );

  file_input.click( );

  if( modal = D.query('.floating-modal' ) ){ D.remove(modal); }
};

const modal_new_file = ( e ) => {
  e.stopPropagation( );
  const parent = D.id('new-elements');
  const modal = D.create( 'div', { className: 'floating-modal' } );
  const div1 = D.create( 'div' );
  const div2 = D.create( 'div' );
  const btnCarpeta = D.create('a', { href: _v, innerHTML: 'Crear carpeta', onclick: modal_crear_carpeta, className: 'folder-add' } );
  const btnArchivo = D.create('a', { href: _v, innerHTML: 'Subir archivo', onclick: modal_subir_archivo, className: 'file-add' } );

  D.append( btnCarpeta, div1 );
  D.append( btnArchivo, div2 );
  D.append( [ div1, div2 ], modal );
  D.append( modal, parent );
}


const toggle_file_info = e => {
  e.stopPropagation( );
  const datos = {
    "Tipo": "Imagen",
    "Tamaño": "166 KB",
    "Almacenamiento utilizado": "166 KB",
    "Ubicación": "Mi unidad",
    "Propietario": "yo",
    "Modificado":"28 ago 2022 por mí",
    "Abierto":"21:44 por mí",
    "Creado":"15:28"
  };
  const aside = D.create('div', { className: 'modal-aside' });
  const header_tools = D.create('div', {className: 'modal-tools'});
  const titulo = D.create('h2', { innerHTML: 'Nombre del archivo' });
  const cerrar = D.create('a', { href: _v, innerHTML: 'cerrar', className: 'icon modal-close', onclick:e=>{ aside.remove( ); }});
  const preview = D.create('img', { src: '/storage/osito.png' });

  const titulo_acceso = D.create('h3',{ innerHTML: 'Usuarios con acceso' });
  const datos_acceso = D.create('div', { innerHTML: 'No compartido', className: 'shared-with' });
  const btn_acceso = D.create('button', { innerHTML: 'Administrar acceso' });

  const titulo_propiedades = D.create('h3',{ innerHTML: 'Propiedades del sistema' });
  const lista_propiedades = D.create('ul');
  for(let i in datos){
    const li = D.create('li');
    const clave = D.create('span', { innerHTML: i +' ' });
    const valor = D.create('span', { innerHTML: datos[i] });
    D.append([clave,valor], li);
    D.append(li, lista_propiedades);
  }

  const desc_container = D.create('div',{ className: 'modal-description' });
  const descripcion = D.create('p',{innerHTML: 'Este es el osito que le regalamos al Fascomp para su día de cumpleaños, hicimos el edit en vivo' });
  const editar_descripcion = D.create('a',{ href: _v, className: 'icon edit' });

  D.append([descripcion, editar_descripcion], desc_container);
  D.append( [titulo, cerrar], header_tools );
  D.append( [header_tools, preview, titulo_acceso, datos_acceso, btn_acceso, titulo_propiedades, lista_propiedades, desc_container], aside );
  D.append(aside, D.query('main'));
}



const modal_usuario = e => {
  e.stopPropagation( );

  fetch( '/get-userdata' ).
  then( r => r.json( ) ).
  then( j => {
    console.log(j);
    const modal = D.create('modal', { className: 'modal-usuario' });
    const avatar = D.create('img', { src: `/users/${j.AVATAR}`});
    const nombre = D.create('p', { innerHTML: j.NOMBRE_PARSEADO });
    const email = D.create('p', { innerHTML: j.EMAIL });
    const editar = D.create('a', { href: '/perfil', innerHTML: 'Modificar datos', className: 'boton-editar'} );

    const salir = D.create('a', { href: '/post-logout', innerHTML: 'Cerrar sesión', className: 'boton-salir'} );
    const cancelar = D.create('a', { href: '/post-cancelar', innerHTML: 'Cancelar cuenta', className: 'boton-cancelar', onclick: e => {
      return confirm('Eh wacho, estas seguro que queres cancelar?' );
    }} );

    D.append( [avatar,nombre,email,editar, salir,cancelar], modal );
    D.append(modal, D.id('user-config') );
  });
}

const open_nav = e =>{
  e.stopPropagation( );
  const nav = D.query('nav');
  nav.classList.add('open');
  document.body.classList.add('nav-open');
}

const close_nav = e =>{
  const nav = D.query('nav');
  nav.classList.remove('open');
  document.body.classList.remove('nav-open');
}



const toggle_darkmode = e => {
  document.body.classList.toggle('dark');
}

const click_eliminar_modales = e => {
  const selectores = arrayModales.join(',');
  const modalParent = e.target.closest(selectores);
  if( ! modalParent ) escuchar_escape( );
}

const descargar_multiples_recursos = ( ) => {
  const items = D.queryAll('.para-descargar');
  const FD = new FormData( );
  Array.from(items).forEach( item => {
    FD.append( 'archivos[]', item.dataset.file );
  } );
  fetch( '/post-zip', { method: 'POST', body: FD } )
  .then(response => response.blob())
  .then(blob => {
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = "zip-castordrive.zip";
      document.body.appendChild(a); 
      a.click();    
      a.remove();        
  });
}

const download_attributes = (boton, filename, downloadname ) => {
  boton.href = '/storage/'+filename;
  boton.download = downloadname;
  boton.removeEventListener('click', descargar_multiples_recursos);
}

const open_direct_resource = item => {
  const is_folder = item.dataset.folder == '1';
  if( is_folder ){
    location.href = `?folder=${item.dataset.file}`; 
  }
}

const open_resource = e => {
  open_direct_resource( e.currentTarget );
}

const prepare_actions = e => {
  const boton_dwl = D.query('.icon.download');
  boton_dwl.classList.remove('hidden');
  boton_del.classList.remove('hidden');
  boton_mv.classList.remove('hidden');

  if( e.ctrlKey ){
    e.currentTarget.classList.toggle('para-descargar');
    const items = D.queryAll('.para-descargar');

    if( items.length == 0 ){
      boton_dwl.classList.add('hidden');
      boton_del.classList.add('hidden');
      boton_mv.classList.add('hidden');
    }else if( items.length == 1 ){
      download_attributes( boton_dwl, items[0].dataset.file, items[0].dataset.name );
    }else{
      boton_dwl.href = 'javascript:void(0)';
      boton_dwl.removeAttribute('download');
      boton_dwl.addEventListener('click', descargar_multiples_recursos);
    }

  //Acá seleccioné un solo recurso, no tengo el ctrl presionado.
  }else{
    const items = D.queryAll('.para-descargar');
    Array.from(items).forEach(i => { i.classList.remove('para-descargar'); });
    download_attributes( boton_dwl, e.currentTarget.dataset.file, e.currentTarget.dataset.name );
    e.currentTarget.classList.add('para-descargar');
  }
}

const eliminar_items = ( e ) =>{
  const items = D.queryAll('.para-descargar');
  const nombres = Array.from(items).map( item => item.dataset.file );
  const params = new URLSearchParams(document.location.search);
  const folder = params.get("folder"); 

  const FD = new FormData( );
  FD.append( 'items', JSON.stringify(nombres) );
  FD.append( 'folder', folder );

  fetch( '/post-delete', { method: 'POST', body: FD } )
    .then( rta => rta.json( ) )
    .then( j => {
      reloadFileList( );
    } );
//  console.log( nombres );
}

const mover_items = ( e ) =>{

}


const scannear_items = ( ) => {
  const items = D.queryAll( 'tbody > tr, #grid ul li' );
  Array.from(items).forEach( i => {
    i.addEventListener('dblclick', open_resource ); 
    i.addEventListener('click', prepare_actions );
  });
}

const populate_grid = formato => {
  const div = D.id('files');
  const FD = new FormData( );
  const params = new URLSearchParams(document.location.search);
  const folder = params.get("folder"); 

  const array = { folder: folder }
  FD.append( 'formato', formato );
  FD.append( 'filtros', JSON.stringify( array ) );
  fetch( '/post-grid', { method: 'POST', body: FD } ). 
  then( r => r.text( ) ). 
  then( t =>{ div.innerHTML = t; scannear_items( ) } );
}

const toggle_grid = e => {
  let formato = '';
  if( e.target.classList.contains('tabla') ){
    formato = 'grilla';
    e.target.classList.replace('tabla','grilla');
  }else{
    formato = 'tabla';
    e.target.classList.replace('grilla','tabla');
  }
  populate_grid( formato );
}

const getFiltros = ( ) =>{
  const filtros = {};
  if( D.id('buscador').value != '' ){
    filtros.buscador = D.id('buscador').value; 
  }
  return JSON.stringify( filtros );
}

const ordenar = num => {
  const div = D.id('files');
  formato = 'tabla';
 
  const filtros = getFiltros( );

  const FD = new FormData( );
  FD.append( 'formato', formato );
  FD.append( 'orden', num );
  FD.append( 'filtros', filtros );

  fetch( '/post-grid', { method: 'POST', body: FD } ). 
  then( r => r.text( ) ). 
  then( t =>{ div.innerHTML = t } );
}

const show_owner = c => {
  D.id('owner-user').style.display = c.value == '' ? 'block' : 'none';
  D.id('owner-user').disabled = ! c.value == '';
}

const show_busqueda_avanzada = e => {
  D.id('form-avanzado').style.display = 'block';
}

const hide_busqueda_avanzada = e => {
  D.id('form-avanzado').style.display = 'none';
}


const toggle_collapse = function(e){
  const list_item_tocado = this.parentNode;
  const parent = this.dataset.parent;
  const current_path = list_item_tocado.dataset.path;

  if( sub_lista = list_item_tocado.querySelector( 'ul') ){
    sub_lista.remove( );
    list_item_tocado.classList.remove( 'expanded' );
  }else{
    const sub_ul = D.create('ul');
    const full_path = current_path.split( '|' );

    let hijos = directorios;
    for( p of full_path ){ hijos = hijos[p].HIJOS; }

    const data_level = parseInt(list_item_tocado.dataset.level) + 1;

    for(let id in hijos){
      const cant_hijos = Object.keys(hijos[id].HIJOS).length;
      const classHijos = cant_hijos > 0 ? 'subitems collapsed' : '';

      const list_item = D.create('li',{ className: classHijos, style: `--data-level: ${data_level}` });
      list_item.dataset.level = data_level;
      list_item.dataset.path = current_path + '|' + hijos[id].ID;
    
      const expandir = D.create('span', { className:'folder-expandir', innerHTML: '-', onclick: toggle_collapse } );
      const vinculo = D.create('a',{ className: 'folder', innerHTML: hijos[id].NOMBRE, href: `/?folder=${hijos[id].URL}` } );


      if( cant_hijos > 0 ) D.append( expandir, list_item );
      D.append( vinculo, list_item );
      D.append( list_item, sub_ul );
    }
    D.append( sub_ul, list_item_tocado );
    list_item_tocado.classList.add( 'expanded' );
  }
}