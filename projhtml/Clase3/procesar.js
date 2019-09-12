

const buscador=document.querySelector("#buscador");
const resultado = document.querySelector('#resultado');
const elementoSeleccionado = document.querySelector('#listTipo');
const lotes = [];
const lotess = [
    {lote:"00001",numslrg:"SLRG001",numcufe:"1",nombreslrg:'Cnsulta de Contribuyente Ãšnico',modulo:'Contribuyente Ãšnico'},
    {lote:"00001",numslrg:'SLRG002',numcufe:"2",nombreslrg:'Alta de Contribuyente Ãšnico',modulo:'Contribuyente Ãšnico'},
    {lote:"00002",numslrg:'SLRG123',numcufe:"3",nombreslrg:'ModificaciÃ³n de Contribuyente Ãšnico',modulo:'Contribuyente Ãšnico'},
    {lote:"00011",numslrg:'SLRG010',numcufe:"144",nombreslrg:'Alta conceptos resoluciÃ³n impuestos',modulo:'Plan de Facilidades'},
    {lote:"00011",numslrg:'SLRG011',numcufe:"177",nombreslrg:'ModificaciÃ³n conceptos resoluciÃ³n impuestos',modulo:'Plan de Facilidades'},
    {lote:"00011",numslrg:'SLRG012',numcufe:"174",nombreslrg:'Consulta concepto resoluciÃ³n impuesto',modulo:'Plan de Facilidades'},
    {lote:"00144",numslrg:'SLRG013',numcufe:"191",nombreslrg:'Consulta al PadrÃ³n de Plan de Facilidades',modulo:'Plan de Facilidades'},
]

// for(let lotecito of lotess){
//     var lote = new Lote(lotecito.lote, lotecito.numslrg, lotecito.numcufe, lotecito.nombreslrg, lotecito.modulo);
//     lotes.push(lote);
// }
//console.log(lotes[0]);
//Manejador de eventos que a medida que se completa el buscador va llamando a Filtrar
buscador.addEventListener('keyup', filtrar);
elementoSeleccionado.addEventListener('onchange', filtrar);
//TESTINGonsole.log(elementoSeleccionado.value);

function filtrar(){
    //console.log(elementoSeleccionado.value);
    const texto = buscador.value.toLowerCase();
    resultado.innerHTML = "";   
    //TESTINGconsole.log("LOTE" + '\t'+ "NUM SLRG" + '\t'+ "CUFE" + '\t'+ "DESC." + '\t\t\t\t\t\t\t\t\t'+ "Modulo");
    console.log(lotes.length);
    for(let lotecito of lotes){
        let numeroLote = lotecito.numeroLote.toLowerCase();
        let numeroCufe = lotecito.numeroCufe.toLowerCase();
        let nombreSlrg = lotecito.nombreSlrg.toLowerCase();
        let numeroSlrg = lotecito.numeroSlrg.toLowerCase();
         //console.log(numeroLote);
        switch(elementoSeleccionado.value)
        {
            case 'cufe':
                    if(numeroCufe.indexOf(texto) !== -1){
                        resultado.innerHTML += `<li>${lotecito.numeroLote} - ${lotecito.numeroSlrg} - ${lotecito.numeroCufe} - ${lotecito.nombreSlrg} - ${lotecito.modulo}</li>`
                        //TESTINGconsole.log(lotecito.lote + '\t'+ lotecito.numslrg + '\t\t'+ lotecito.numcufe + '\t'+ lotecito.nombreslrg + '\t\t'+ lotecito.modulo);
                    }
                break;
            case 'numslrg':
                    if(numeroSlrg.indexOf(texto) !== -1){
                        resultado.innerHTML += `<li>${lotecito.lote} - ${lotecito.numslrg} - ${lotecito.numcufe} - ${lotecito.nombreslrg} - ${lotecito.modulo}</li>`
                        //TESTINGconsole.log(lotecito.lote + '\t'+ lotecito.numslrg + '\t\t'+ lotecito.numcufe + '\t'+ lotecito.nombreslrg + '\t\t'+ lotecito.modulo);
                    }
                    break;
            case 'nombreslrg':
                    if(nombreSlrg.indexOf(texto) !== -1){
                        resultado.innerHTML += `<li>${lotecito.lote} - ${lotecito.numslrg} - ${lotecito.numcufe} - ${lotecito.nombreslrg} - ${lotecito.modulo}</li>`
                        //TESTINGconsole.log(lotecito.lote + '\t'+ lotecito.numslrg + '\t\t'+ lotecito.numcufe + '\t'+ lotecito.nombreslrg + '\t\t'+ lotecito.modulo);
                    }
                break;
            case 'lote':
                    if(numeroLote.indexOf(texto) !== -1){
                        resultado.innerHTML += `<li>${lotecito.lote} - ${lotecito.numslrg} - ${lotecito.numcufe} - ${lotecito.nombreslrg} - ${lotecito.modulo}</li>`
                        //TESTINGconsole.log(lotecito.lote + '\t'+ lotecito.numslrg + '\t\t'+ lotecito.numcufe + '\t'+ lotecito.nombreslrg + '\t\t'+ lotecito.modulo);
                    }
                break;
            default:
                    resultado.innerHTML += `<li>${lotecito.lote} - ${lotecito.numslrg} - ${lotecito.numcufe} - ${lotecito.nombreslrg} - ${lotecito.modulo}</li>`;
                    break;

        }

    }
}

//-------------------------------------CONSTRUCTOR LOTE-----------------------------------------------------------------------

function Lote(numeroLote, numeroSlrg, numeroCufe, nombreSlrg, modulo) {

    this.numeroLote = numeroLote;
    this.nombreSlrg = nombreSlrg;
    this.numeroSlrg = numeroSlrg;
    this.numeroCufe = numeroCufe;
    this.modulo = modulo;
}

//---------------------------------------AGREGAR LOTE-------------------------------------------------------------------

document.getElementById("btnagregar").addEventListener("click", altaLote);
function altaLote(){
    let numeroLote = document.getElementById('numeroLote').value;
    let numeroSlrg = document.getElementById('numeroslrg').value;
    let nombreSlrg = document.getElementById('nombreslrg').value;
    let numeroCufe = document.getElementById('numerocufe').value;
    let modulo = document.getElementById('modulo').value;
    var lote = new Lote(numeroLote, numeroSlrg, numeroCufe, nombreslrg, modulo);
    lotes.push(lote);
    alert(numeroLote);
    
}
