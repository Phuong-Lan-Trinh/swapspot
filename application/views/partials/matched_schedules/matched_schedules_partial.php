<script type="text/ng-template" id="matched_schedules.html">
    <style>
        div.position{
            position: absolute;
            top: 20%;
            right: 60%;
        }
        .map {
            height: 400px;
            width: 600px;
        }
    </style>

    
    <div ng-controller="MatchedScheduleIndexCtrl" class="container-fluid">
        <div class="row-fluid">
            <div class="span4 position">
            <!--Sidebar content-->
                <h3 style="text-align:center;">Pick parking spot</h3> 
                <table class="table table-striped table-hover">
                    <tr><td>{{address}}<td></tr>
                    <tr><td>{{address}}<td></tr>
                    <tr><td>{{address}}<td></tr>
                    <tr><td>{{address}}<td></tr>
                    <tr><td>{{address}}<td></tr>
                    <tr><td>{{address}}<td></tr>
                    <tr><td>{{address}}<td></tr>
                    
                </table>             
                
                <button  class="btn-primary btn-large" style="position:absolute;right:10%;top:103%" type="submit" value="true" >SWAP SPOT</button>
            </div>
            <div class="span8">
               <!--Body content-->
                
            </div>
            <div style= "position:absolute;top:20%;right:10%">
                <!-- Giving the div an id="map_canvas" fix problems with twitter bootstrap affecting google maps -->
                <div id="map_canvas" ui-map="myMap" class="map" ui-options="mapOptions">       
            </div>
        </div>
    </div>
</script>