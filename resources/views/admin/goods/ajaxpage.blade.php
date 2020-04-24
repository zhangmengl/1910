@foreach ($goods as $v) 
			      <tr>
				        <td>{{$v->goods_id}}</td>
				        <td>{{$v->goods_name}}</td>
                <td>{{$v->goods_price}}</td>
                <td>{{$v->goods_num}}</td>
                <td>
                    @if($v->goods_img)
                    <img src="{{env('ADMINLOGO_URL')}}{{$v->goods_img}}" width="45px" height="45px">
                    @endif
                </td>
                <td>
                    @if($v->goods_imgs)
                    @php $goods_imgs=explode('|',$v->goods_imgs) @endphp
                    @foreach($goods_imgs as $vv)
                    <img src="{{env('ADMINLOGO_URL')}}{{$vv}}" width="45px" height="45px">
                    @endforeach
                    @endif    
                </td>
                <td>{{$v->goods_desc}}</td>
                <td>{{$v->goods_score}}</td>
                <td>{{$v->is_new==1 ? "√" : "×"}}</td>
                <td>{{$v->is_best==1 ? "√" : "×"}}</td>
                <td>{{$v->is_hot==1 ? "√" : "×"}}</td>
                <td>{{$v->is_up==1 ? "√" : "×"}}</td>
				        <td>{{$v->brand_name}}</td>
                <td>{{$v->cate_name}}</td>
                <td>
                    <a href="{{url('/goods/edit/'.$v->goods_id)}}" class="btn btn-primary">编辑</a>
                    <a href="{{url('/goods/destroy/'.$v->goods_id)}}" class="btn btn-danger">删除</a>
                </td>
			      </tr>
			      @endforeach
            <tr><td colspan="15">{{$goods->appends($all)->links()}}</td></tr>