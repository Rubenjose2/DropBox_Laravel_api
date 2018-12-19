
<div>


    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{route('file.upload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <legend>File Uploader Dropbox</legend>

                    <div class="form-group">
                        <label for="">Please select the Game </label>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label"></label>
                            <select class="form-control" id="school" name="school">
                                @foreach($data as $record)
                                    <option data-content="{{$record->id}}">{{$record->home_name}} <strong>Vs</strong> {{$record->event_opponent_name}} | {{$record->event_date}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file" multiple>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

</div>