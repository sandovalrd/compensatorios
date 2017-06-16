    var tab;
    var filas;

    function iniciarTabla() {
      tab = document.getElementById('tabla');
      filas = tab.getElementsByTagName('tr');
      for (i=0; ele = filas[i]; i++) {
        ele.getElementsByTagName('img')[0].onclick = function() { mover(this,-1) }
        ele.getElementsByTagName('img')[1].onclick = function() { mover(this,1) }
      }
      mostrarOcultar();
    }

    // Ocultar imagen subir en primera fila y bajar en última fila. Mostrar el resto de imágenes
    function mostrarOcultar() {
      for (i=0; ele = filas[i]; i++) {
        ele.getElementsByTagName('img')[0].style.visibility = (i==0) ? 'hidden' : 'visible';
        ele.getElementsByTagName('img')[1].style.visibility = (i==filas.length-1) ? 'hidden' : 'visible';
        ele.getElementsByTagName('a')[1].style.visibility = (i!=filas.length-1) ? 'hidden' : 'visible';
      }
    }

    function moverDb(id1, id2){
      var url = $('#form').attr('action');
      data = { id1: id1, id2: id2 };
      $.get(url, data, function(response){
          //console.log(response);
      }).fail(function(){
          alert('Hubo un error en el cambio de guardia');
      });
    }

    function mover(obj,num) {
      fila = obj.parentNode.parentNode;
      for (i=0; ele = tab.getElementsByTagName('tr')[i]; i++)
        if (ele == fila) {numFila=i; break}
        copia = filas[numFila].cloneNode(true);
        ele2 = tab.getElementsByTagName('tr')[i+num];
        moverDb($(ele).find('td').eq(0).html(), $(ele2).find('td').eq(0).html());
        fecha = $(ele).find('td').eq(3).html();
        fecha2 = $(ele2).find('td').eq(3).html();
        
        $(copia).find('td').eq(3).html(fecha2);
        $(ele2).find('td').eq(3).html(fecha);
        

        // Añadir evento onclick a las imágenes
        copia.getElementsByTagName('img')[0].onclick = function() { mover(this,-1) }
        copia.getElementsByTagName('img')[1].onclick = function() { mover(this,1) }

        tab.removeChild(filas[numFila]);
        numFila += num;
        if (numFila > filas.length-1) 
          tab.appendChild(copia);
        else
          tab.insertBefore(copia,filas[numFila]);
      mostrarOcultar();
    }
