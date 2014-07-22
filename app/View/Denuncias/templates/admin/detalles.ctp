<blockquote class="text-left" style="margin-bottom:0;">
  <a href="#" data-table-row-dismiss class="close pull-right">&times;</a>

	<table style="width:90%">
		<tbody>
				<tr>
					<th style="width:50%"> Quién Reporta</th> <th style="width:30%">Motivo de Reporte</th> <th style="width:20%">  Fecha </th>
				</tr>
				{{~it.denunciante : value:index}}
				<tr style="padding-bottom:10px">
					<td style="padding-bottom:10px">  <a> {{=value.correo}}</a> , {{=value.telefono}}</td>
					<td style="padding-bottom:10px"> {{=value.motivo.text}}</td>
					<td style="padding-bottom:10px">  {{=value.created.str}} </td>
				</tr>
				{{~}}

		</tbody>
	</table>
</blockquote>