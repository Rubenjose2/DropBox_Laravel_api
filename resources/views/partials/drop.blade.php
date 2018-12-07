<div>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{route('dropzone')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="csrf_token" value ="{{csrf_token()}}"/>
                    <legend>File Uploader Dropbox</legend>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Instructions</h3>
                        </div>
                        <div class="panel-body">
                            <strong>Number of pictures allow: </strong> 30<br>
                            <small>Please avoid to load blurring pictures</small> <br/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Please select the Game </label>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <select class="form-control" id="school" name="school">
                                <option value="JEBSTUARTHSvsCCHS">JEB Stuart High School Vs Culpeper Country High School @7:00 pm</option>
                                <option value="JEBSTUARTHSvsEVHS">Easter View High School Vs Culpeper Country High School @7:00 pm</option>
                                <option value="CVHSVsAHS">Charlotes Village High School Vs Albemarle High School @7:00 pm</option>
                            </select>
                        </div>
                    </div>

                    <div class="dropzone" id="myDropzone"></div>
                    <hr>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Pictures Bulk information</h3>
                        </div>
                        <div class="panel-body">
                            <strong>Total Amount of Pictures to be upload: </strong> <span id="counter"></span><br/>
                            <strong>Total size of the Bulk: </strong><span id="bulk_size"></span><br>

                            {{--Progress Bar--}}

                            <div class="progress">
                                <div id="myprogressbar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                    <span class="sr-only">45% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary disabled" id="submit-all">Submit</button>


                </form>
            </div>
        </div>
    </div>

</div>

