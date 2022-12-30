$(document).ready( function () 
{
    var table = $('#displayarticles').DataTable
    (
    {
        "order": [[ 1, "desc" ]],   
        processing: true,
        ajax:
        {
            url :"/listofarticles", // json datasource
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
            {data: "4", visible: false},
            {
                data: null,
                className: "center",
                defaultContent: '<button type="button" class="btn btn-danger" id="btn-delete">Supprimer</button></td><td><button type="button" class="btn btn-success" id="btn-update">Mettre à jour</button></td>'
            }
        ]
    }
    );
    
    //List of posts whith numbers into the board
    //Create index for table at columns zero
    table.on('order.dt search.dt', function () 
    {
        table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) 
        {
            cell.innerHTML = i + 1;
        });
    }).draw();

        //Buttons
        if($("#hideSaveDatas").click(function()
            {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) 
                        {
                            return data[5] !== "Sauvegarder";
                        }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            }));


        if($("#listofpost").click(function() 
            {
                $.fn.dataTable.ext.search.pop();
                table.draw();
            }));

        if($("#hidePublishedDatas").click(function() 
            {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) 
                        {
                            return data[5] !== "Valider";
                        }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            }));

    //Delete posts
    $('#displayarticles').on( 'click', '#btn-delete', function () 
    {
        var datas = table.row( $(this).parents('tr') ).data();
        var id = datas[ 0 ];

        if(confirm("Voulez vous supprimer cet article?"))
        {
            $.ajax
            ({
                url:"/deletepost",
                method:"POST",
                data:{id:id},
                dataType: 'html',
                success:function(data)
                {
                    var url = '/confirmdeletepost';
                    window.location.href = url;
                },
                error:function(response)
                {
                    alert(response);
                }
            });
        };            
    } );

    //Update posts
    $('#displayarticles').on( 'click', '#btn-update', function (e) 
    {
        var datas = table.row( $(this).parents('tr') ).data();
        var id = datas[ 0 ];

        //Here the var 'tr' make a reference to the object JQuery which select all the div into the document.
        var $tr = $(this).closest('tr');//here we hold a reference to the clicked tr which will be later used to delete the row
        if(confirm("Voulez vous modifier cet article?"))
        {
            var url = "/updatepost&id="+id; 
            window.location.href = url;                              
        };            
    });
});


