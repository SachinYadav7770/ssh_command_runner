@foreach ($projectData as $projectId => $project)
    <tr id="{{ $projectId }}" data-project-name="{{ $project['name'] }}">
        <td>{{ $project['name'] }}</td>
        <td><button class="callCommand" data-target="1">pull</button></td>
        <td><button class="callCommand" data-target="2">Optimize</button></td>
    </tr>
@endforeach