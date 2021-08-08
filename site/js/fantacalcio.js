salvaGiornata = function(idgiornatafc, idgiornatasa){

    var message = ""
    if(idgiornatafc == null)
        message = 'giornata selezionata non valida';
    if(message == "" && (idgiornatasa == 0))
        message = 'giornata serie a non valida';
    
    if (message != "")
    {
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }

    var action ="salvafc";
    $.ajax({
            type:'POST',
            url:'amministra_giornate_controller.php',
            data: {
                "action": action,
                "idgiornatafc": idgiornatafc,
                "idgiornatasa": idgiornatasa,
            },
            success:function(data){
                modalPopupResult(data);
            }
    }); 
}

salvaSquadrePartita = function(id1, id2, giornata){
    var message = ""
    if(message == "" && (id1 == null || id1 == ""))
    {
        message = 'selezionare la squadra 1';
    }
    if(message == "" && (id2 == null || id2 == ""))
    {
        message = 'selezionare la squadra 2';
    }
    if(message == "" && (id1== id2))
    {
        message = 'le due squadre devono essere diverse';
    }
    if (message != "")
    {
        $( "#dialog" ).prop('title', "ERROR");                
        $( "#dialog p" ).html(message);
        $( "#dialog" ).dialog({modal:true});
        return false;
    }

    var idsquadre = [id1, id2];
    $.ajax({
        type:'POST',
        url:'match_c_salvasquadre.php',
        data: {"idgiornata": giornata, "idsquadre": JSON.stringify(idsquadre)},
        success:function(data){
            modalPopupResult(data);
        }
    });
};