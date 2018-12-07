<div>

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{route('dropzone')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" id="csrf_token" value ="{{csrf_token()}}"/>
                    <legend>File Uploader Dropbox</legend>

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
                    <button type="submit" class="btn btn-primary" id="submit-all">Submit</button>


                </form>
            </div>
        </div>
    </div>

</div>

