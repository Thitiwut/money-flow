@extends('layouts.app')
@section('style')
@endsection
@section('content')
<div class="container">
    <div>

        <form class="form-inline text-center">
            <div class="form-group">
                <label for="month">
                    Month
                </label>
                <select  class="form-control" id="month" name="month">
                    <option value="">
                        --Month--
                    </option>
                    @if(isset($Month))
                    @foreach($Month as $month)
                    <option value="{{$month->id}}">
                        <?php echo date('F', strtotime($month->
                        created_at)); ?>
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="category">
                    Category
                </label>
                <select  class="form-control" id="category" name="category">
                    <option value="">
                        --Category--
                    </option>
                    @if(isset($Category))
                    @foreach($Category as $category)
                    <option value="{{$category->id}}">
                        {{$category->
                        name}}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
            <button type="submit" class="btn btn-default">
                Getlist
            </button>
        </form>
    </div>
    <hr/>
    <div>
        <div style="overflow: hidden;">
            <table id="myTable" class="table table-striped table-hover ">
                <thead>
                    <tr >
                        <th>
                            Name
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Type
                        </th>
                        <th >
                            Category
                        </th>
                        <th>
                            Date
                        </th>
                      <!--   <th>
                            Plan
                        </th>-->
                    </tr >
                </thead>
                <tbody>
                    @if(isset($finances))
                    @foreach ($finances as $key =>
                    $finance)
                    <tr >
                        <td>
                            {{ $finance->
                            name}}
                        </td>
                        <td class="text-info">
                            {{ $finance->
                            amount}}
                        </td>
                        <td>
                            <?php echo ($finance->
                            type == 0) ? "Expense" : "Income"; ?>
                        </td>
                        <td class="text-warning">
                            {{ $finance->
                            category }}
                        </td>
                        <td>
                            {{ $finance->
                            created_at }}
                        </td>
                       <!-- <td>
                            {{ $finance->
                            plan }}
                        </td>-->
                    </tr>
                    @endforeach
                    {!! $finances->
                    links() !!}
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
	function parseQueryString(val) {
		var result = "Not found",
		tmp = [];
		var items = location.search.substr(1).split("&");
		for (var index = 0; index < items.length; index++) {
			tmp = items[index].split("=");
			if (tmp[0] === val) result = decodeURIComponent(tmp[1]);
		}
		return result;
	}
	$(document).ready(function(){
		$('#month').val(parseQueryString('month'));
		$('#category').val(parseQueryString('category'));
	});
</script>
@endsection

