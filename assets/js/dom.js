const DOM = function( ){
    //publica... this.loquesea es accesible desde afuera de la función como VARIABLE.loquesea
    this.id = str => document.getElementById(str);
    this.query = selector => document.querySelector(selector);
    this.queryAll = selector => document.querySelectorAll( selector );
    this.create = (tag, attrs = { }) => Object.assign( document.createElement(tag), attrs );
    this.remove = element =>{ element.remove( ); }
    this.append = (hijo, padre = document.body) =>  {
        ( hijo instanceof Array ) ?
        hijo.map( h => { padre.appendChild(h) } ) :
        padre.appendChild( hijo ); 
    }
}