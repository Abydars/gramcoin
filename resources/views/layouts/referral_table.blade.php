@if(!empty($list))
    <div class="referral-table">
        <table class="table {{ $id ? '' : ' parent' }}"
               id="{{ $id ? 'referral-' . $id : '' }}">
            @if(!$id)
                <thead>
                <tr>
                    <th>Name</th>
                    <th>ICO</th>
                    <th>Ref Level</th>
                </tr>
                </thead>
            @endif
            <tbody>
            @foreach($list as $row)
                <tr class="ref">
                    <td width="60%">
                        <span style="padding-left: {!! $id ? count($list) * 10 : 0 !!}px"></span>{!! (!empty($row['referrals']) ? '<i class="fa arrow"></i> ' : '') !!}{{ $row['full_name'] }}
                        ({!! count($row['referrals']) !!})
                    </td>
                    <td width="20%">
                        {{ $row['ico'] }}
                    </td>
                    <td width="20%">
                        LVL {{ $row['level'] }}
                    </td>
                </tr>
                @if(!empty($row['referrals']))
                    <tr>
                        <td colspan="3" class="p0 b0">
                            {!! Referral::renderReferralList($row['referrals'], $row['id']) !!}
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endif