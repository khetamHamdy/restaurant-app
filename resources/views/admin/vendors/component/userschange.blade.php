<div class="flex-row-fluid ml-lg-8">
    <div class="card card-custom gutter-b example example-compact">

        <div class="card-header">
            <h3 class="card-title">{{__('cp.change_price')}}</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-hover tableWithSearch" id="tableWithSearch">
                <thead>
                <tr>
                    <th class="wd-1p no-sort">
                    </th>
                    <th class="wd-5p"> {{ucwords(__('user'))}}</th>
                    <th class="wd-5p"> {{ucwords(__('mobile'))}}</th>
                    <th class="wd-5p"> {{ucwords(__('email'))}}</th>
                    <th class="wd-10p"> {{ucwords(__('created'))}}</th>
                    <th class="wd-10p"> {{ucwords(__('updated'))}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($item->changePriceUsers as $one)
                    <tr class="odd gradeX" id="tr-{{$one->id}}">
{{--                        <td class="v-align-middle wd-5p">--}}
{{--                            <div class="checkbox-inline">--}}
{{--                                <label class="checkbox">--}}
{{--                                    <input type="checkbox" value="{{$one->id}}" class="checkboxes"--}}
{{--                                           name="chkBox"/>--}}
{{--                                    <span></span></label>--}}
{{--                            </div>--}}
{{--                        </td>--}}
                        <td class="v-align-middle wd-25p">{{$loop->iteration}}</td>
                        <td class="v-align-middle wd-25p">{{$one->user_name}}</td>
                        <td class="v-align-middle wd-25p">{{$one->mobile ?? '--'}}</td>
                        <td class="v-align-middle wd-25p">{{$one->email}}</td>
                        <td class="v-align-middle wd-10p">{{$one->created_at->format('Y-m-d') ?? ''}}</td>
                        <td class="v-align-middle wd-10p">{{$one->updated_at->format('Y-m-d') ?? ''}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

