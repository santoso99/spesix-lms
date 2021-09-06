<select class="form-control" name="learning_topic_id" id="topicSelectBox">
    @foreach($topics as $topic)
        <option value="{{$topic->id}}">{{$topic->name}}</option>
    @endforeach
</select>