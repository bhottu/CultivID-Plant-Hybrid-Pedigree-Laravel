@foreach($approvedPlants as $item)


<tr class="border-b hover:bg-gray-200 text-xs cursor-pointer"
onclick="window.location='{{ route('plant-submissions.show', $item) }}'">

<td class="p-2">

@php
$images = [];
if ($item->image) {
    $decoded = json_decode($item->image, true);
    $images = is_array($decoded) ? $decoded : [$item->image];
}
$first = count($images) ? $images[0] : null;
@endphp

@if($first)
<img src="{{ asset('storage/'.$first) }}"
class="w-12 h-12 object-cover rounded border border-gray-300">
@else
<div class="w-12 h-12 flex items-center justify-center rounded border border-gray-300 bg-gray-100 text-xxxs text-gray-500">
No Image
</div>
@endif

</td>

<td class="p-2 align-top ">
<span class="dark:text-gray-200 italic font-medium md:text-sm">
{{ \Illuminate\Support\Str::words($item->plant_id, 3, '..') }}
</span>

@if($item->plant_id_var == 0)
<span class="block text-[10px] md:text-sm mt-1 text-green-700 font-bold">
Variegated
</span>
@endif

<div class="text-[10px] md:text-sm text-gray-400 mt-1 italic">
Breeder: {{ $item->penyilang ?? 'Unknown' }}
</div>
</td>

<td class="p-2 italic text-gray-700 dark:text-gray-400 text-xs md:text-sm">
{{ $item->induk_betina }}
</td>

<td class="p-2 italic text-gray-700 dark:text-gray-400 text-xs md:text-sm">
{{ $item->induk_jantan }}
</td>

</tr>


@endforeach