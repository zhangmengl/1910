                @foreach ($link as $v) 
			      <tr>
				        <td>{{$v->link_id}}</td>
				        <td>{{$v->link_name}}</td>
                <td>{{$v->link_url}}</td>
                <td>{{$v->link_type=="1" ? "LOGO链接" : "文字链接"}}</td>
                <td>@if($v->link_logo)<img src="{{env('ADMINLOGO_URL')}}{{$v->link_logo}}" width="45px" height="45px">
                    @endif
                </td>
                <td>{{$v->link_man}}</td>
                <td>{{$v->link_desc}}</td>
                <td>{{$v->link_show=="1" ? "√" : "×"}}</td>
                <td>
                    <a href="{{url('/link/edit/'.$v->link_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/link/destroy/'.$v->link_id)}}" class="btn btn-danger">删除</a>
                </td>
			      </tr>
			      @endforeach
                <tr><td colspan="9">{{$link->appends($all)->links()}}</td></tr>
