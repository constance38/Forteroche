$(document).ready( function () 
{
    var table = $('#displaycomments').DataTable
    (
    {
        "order": [[ 1, "desc" ]],   
        processing: true,
        ajax:
        {
            url :"/listofcomments", // json datasource
            type:"POST",
            dataType: 'json'
        },
        "language": 
        {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        },
        columnsDefs:
        [{
            "className": 'dt-center',
            "targets": [ 0 ],
            "visible": false
        }],
        columns: 
        [
            {data: null},
            {data: "0", visible: false},
            {data: "1"},
            {data: "2"},
            {data: "3"},
            {data: "4"},
            {data: "5"},
            {
                data: null,
                className: "center",
                defaultContent: '<td><button type="button" class="btn btn-danger" id="btn-delete">Supprimer</button></td>'
            }
        ]
    });
    
    //List of posts whith numbers into the board
    //create index for table at columns zero
    table.on('order.dt search.dt', function () 
    {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) 
        {
            cell.innerHTML = i + 1;
        });
    }).draw();

    //Buttons
    if($("#listofcomments").click(function() 
    {
        $.fn.dataTable.ext.search.pop();
        table.draw();
    }));

    //delete Posts
    $('#displaycomments').on( 'click', '#btn-delete', function () 
    {
        var datas = table.row( $(this).parents('tr') ).data();
        var id = datas[ 0 ];

        if(confirm("Voulez vous supprimer ce commentaire?"))
        {
            console.log(id);
            $.ajax
            ({
                url:"/deletecomment",
                method:"POST",
                data:{id:id},
                dataType: 'html',
                success:function(data)
                {
                    var url = '/confirmdeletecomment';
                    window.location.href = url;
                },
                error:function(response)
                {
                    alert(response);
                }
            });
        };            
    } );
});


