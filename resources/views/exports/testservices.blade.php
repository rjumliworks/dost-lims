<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<body>
    <table>
        <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
            <tr>
                <td style="width: 300px; text-align: center; font-weight: bold;">Category</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Type</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Name</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Testname</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Method Code</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Method</td>
                <td style="width: 350px; text-align: center; font-weight: bold;">Reference</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Fee</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Status</td>
                <td style="width: 300px; text-align: center; font-weight: bold;">Availability</td>
            </tr>
        </thead>
        <tbody>
        @foreach($lists as $list)
            <tr style="text-align: center; font-size: 9px; color: #072388;">
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['category']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['type']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['name']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['testname']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['method_code']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['method']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['reference']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['fee']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['status']}}</td>
                <td style="text-align: center; background-color: {{ ($list['status'] === 'Suspended') ? '#f5ac9f' : '' }};">{{$list['availability']}}</td>
            </tr>
        @endforeach
        </tbody>

    </table>
</body>
</html>
