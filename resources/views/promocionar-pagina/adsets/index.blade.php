 <h3>Grupos de Anuncios - Ad Sets</h3>

 <a href="{{ route('ad-set.show', $campaign->id) }}" class="btn btn-primary">Crear Grupo</a>

 <br/>

 <table>
     <thead>
         <tr>
             <th>Id</th>
             <th>Nombre</th>
             <th>Objetivo</th>
             <th>Fecha</th>
             <th colspan="2">Acción</th>
         </tr>
     </thead>
     <tbody>
         {{-- @foreach ($campaigns as $campaign)
             <tr>
                 <td>{{ $campaign['id'] }}</td>
                 <td>{{ $campaign['name'] }}</td>
                 <td>{{ $campaign['objective'] }}</td>
                 <td>{{ $campaign['created_at'] }}</td>
                 <td>
                     <a href="{{ route('campaign.edit', $campaign['id']) }}" class="btn btn-primary">Ver</a>
                 </td>
                 <td>
                     <a href="{{ url('campaign.delete', ['id' => $campaign['id']]) }}"
                         class="btn btn-danger">Eliminar</a>
                 </td>
             </tr>
         @endforeach --}}
     </tbody>
 </table>
