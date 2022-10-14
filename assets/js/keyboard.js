const escuchar_escape = ( ) => {
  arrayModales.forEach( selector => {
    const objetivos = D.queryAll(selector);
    Array.from(objetivos).forEach( o => { o.remove(); } );
  } );
}


const escuchar_f = ( event ) => {
  modal_crear_carpeta( event );
}

const escuchar_t = ( event ) => {
  modal_subir_archivo( event );
}

const escuchar_enter = ( event ) => {
  if( seleccionado = document.querySelector('.para-descargar' ) ){
    open_direct_resource( seleccionado );
  }
}

let currentIndex = 0;
const navigate_files = ( sentido ) => {
  const recursos = document.querySelectorAll('#files tbody tr');
  if( recursos.length == 0 ) return false;
  currentIndex += sentido;

  if( currentIndex < 0 ){ currentIndex = 0; return false; }
  if( currentIndex >= recursos.length  ){ currentIndex = recursos.length - 1; return false; }

  if( anterior = document.querySelector('.para-descargar' ) ) anterior.classList.remove('para-descargar');

  recursos[ currentIndex ].classList.add( 'para-descargar' );
}

const escuchar_tecla = e =>{
  e.preventDefault( );
  const modal = document.querySelector('.modal');

  switch(e.key){
    case 'Escape': escuchar_escape( ); break;
    case 'Enter': escuchar_enter( ); break;
    case 'f': case 'F': if( e.shiftKey && ! modal ) escuchar_f( e ); break;
    case 't': case 'T': if( e.shiftKey && ! modal ) escuchar_t( e ); break;
    case 'ArrowUp': if( ! modal ) navigate_files( -1 ); break;
    case 'ArrowDown': if( ! modal ) navigate_files( 1 ); break;
  }
}
