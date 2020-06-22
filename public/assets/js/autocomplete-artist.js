$('input[data-id=artistName]').autocomplete({
    minLength: 2,

    position : {
        my : 'top',
        at : 'bottom'
    },

    source : function(requete, response) {
        const recherche = $("input[data-id=artistName]").val();
        const objData = 'search=' + recherche;
        const url = $(this.element).attr('data-url');

        $.ajax({
            url: url,
            data: objData,
            dataType: 'json',
            type: 'POST',

            success : function(donnee){
                response($.map(donnee, function(objet){
                    return objet.name;
                }));
            }
        });
    }, // FIn de source

    select : function(event, ui){
        $("input[data-id=artistName]").val( ui.item.name );
    }

});