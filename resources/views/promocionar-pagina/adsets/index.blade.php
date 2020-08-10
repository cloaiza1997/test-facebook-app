 <h3>Grupos de Anuncios - Ad Sets ({{ count($ad_sets) }})</h3>

 <a href="{{ route('ad-set.show', $campaign->id) }}" class="btn btn-primary">Crear Grupo</a>

 <br/>

 <table>
     <thead>
         <tr>
             <th>Id</th>
             <th>Nombre</th>
             <th>Inicio</th>
             <th>Fin</th>
             <th>Ppto Diario</th>
             <th>Objetivo de Optimización</th>
             <th>Evento de Facturación</th>
             <th>Creación</th>
             <th colspan="2">Acción</th>
         </tr>
     </thead>
     <tbody>
         @foreach ($ad_sets as $ad_set)
             <tr>
                 <td>{{ $ad_set['id'] }}</td>
                 <td>{{ $ad_set['name'] }}</td>
                 <td>{{ $ad_set['start_time'] }}</td>
                 <td>{{ $ad_set['end_time'] }}</td>
                 <td>$ {{ $ad_set['daily_budget'] }}</td>
                 <td>{{ $ad_set['optimization_goal'] }}</td>
                 <td>{{ $ad_set['billing_event'] }}</td>
                 <td>{{ $ad_set['created_at'] }}</td>
                 <td>
                     <a href="{{ route('ad-set.edit', "{$campaign->id}-{$ad_set['id']}") }}" class="btn btn-primary">Ver</a>
                 </td>
                 <td>
                    @section('action')
                        {{ route('ad-set.destroy', "{$campaign->id}-{$ad_set['id']}") }}
                    @overwrite
                    @include('layouts.partials.form-delete')
                 </td>
             </tr>
         @endforeach
     </tbody>
 </table>
