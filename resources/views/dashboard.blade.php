<!DOCTYPE html>
<html>
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
        body{
            margin-top: 2%;
            margin-left: 2%;
            margin-right: 2%;
        }
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
        .table-heading{
            text-align: center;
        }
        .command-status{
            height:330px;
            width:100%;
            /* background-color:#CCC; */		
            overflow-y:auto;
            float:left;
            position:relative;
            /* border-radius: 4%; */
        }
        .command-status span{
            display: block;
        }
        .command-status div:hover{
            background-color: #d8d8d8;
            /* color: aqua; */
        }
        .container {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            margin-top: 20px;
        }
        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }
        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }
        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }
        .project-info{
            text-align: end;
            font-size: 10px;
        }
        .server-name{
            display: flex;
        }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body>

        <h2>HTML Table</h2>

        <div class="server-name">
            <input type="radio" id="server1" name="server" value="20" checked>
            <label for="server1">20</label><br>
            <input type="radio" id="server2" name="server" value="test">
            <label for="server2">test</label><br>
            <input type="radio" id="server3" name="server" value="staging">
            <label for="server3">staging</label>
        </div>

        <table> 
            <tbody class="heading">
                <tr>
                    <th class="table-heading" colspan="3">20</th>
                </tr>
                <tr>

                    <th>Projects</th>
                    <th>Git command</th>
                    <th>Php command</th>
                </tr>
            </tbody>
            <tbody class="mainTable">
            </tbody>
        </table>
        <div class="container command-status">

        </div>
        <p></p>
    </body>
    <script>
        class PrioSlickSlider{
            constructor(){
                const currentObj = this;

                //load Project Data
                currentObj.loadProjectTable();
                $(document).on("click", 'input[name="server"]', function () {
                    let serverName = $(this).val();
                    currentObj.loadProjectTable(serverName);
                });

                // request Call
                $(document).on("click", '.callCommand', function () {
                    currentObj.prepareRequestData(this)
                });
            }

            loadProjectTable(serverName = '20'){
                $('.table-heading').text(serverName);
                $('.projectData').find('tbody.mainTable').html('loading...');
                let data = {'serverName':serverName};
                $.ajax('projectData', {
                    type: 'GET',  // http method
                    data: data,  // data to submit
                    success: function (data, status, xhr) {
                        console.log(data);
                        $('table').find('tbody.mainTable').html(data);
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                        $('.projectData').find('tbody.mainTable').html(errorMessage);
                    }
                });
            }

            prepareRequestData(obj){
                let serverName = $('input[name="server"]:checked').val();
                let commandId = $(obj).data("target");
                let parentObj = $(obj).parents('tr');
                let projectId = $(parentObj).attr("id");
                let projectName = $(parentObj).data("project-name");
                let url = 'command';
                let data = {'serverName':serverName,'projectId':projectId,'commandId': commandId};
                this.callAjax('POST',url,data)
            }

            callAjax(method='GET',url,data){
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    }
                });
                $.ajax(url, {
                    type: method,  // http method
                    data: data,  // data to submit
                    success: function (data, status, xhr) {
                        console.log(data);
                        $('.command-status').append(data.responseHtml);
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                        $('.command-status').append(errorMessage);
                    }
                });
            }
        }
        let prioSlickSlider = new PrioSlickSlider;
    </script>
</html>

