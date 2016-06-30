
select * from painel;

/* insert para senha normal */
insert into painel
(senha_prioridade,senha_atendida)
values
(default, default);

/* insert para senha_prioridade */
insert into painel
(senha_prioridade,senha_atendida)
values
(1, default);

select * from painel;


/* 
Esta query ira trazer o proximo cliente a ser atendido seguindo esta regra:

1)Proximo ao ser atendido
somente sera chamado o proximo paciente com a senha ainda nao atendida, 
por isto o "where senha_atendida=0";

2)Pacientes com prioridade
Pacientes com limitacao terao prioridade, entao nesta query esta relizando
chamadas priorizando pacientes com esta senha.
A coluna senha_prioridade, é gravado sempre o valor 0 ou 1, zero significa que 
aquela senha é de um paciente comum, o valor um e o indicador que aquele 
paciente tem direito a prioridade no atendimento.
A regra na query para que ele seja chamado na frente dos outros é 
"order by senha_prioridade desc", ou seja, havendo algum paciente que ja tenha 
retirado a senha, este order by ira listar em ordem decrescente, 
chamando primeiro o paciente em ordem de chegada que esta em prioridade.

3)Pacientes com senha normal
Neste caso, sera chamado o proximo da fila onde senha_atendida seja igual a zero,
senha_prioridade igual a zero e "order by id asc", ou seja, por ordem de chegada.

Em todos os casos acima, quando o atendente chama a proxima senha, é rodada
uma query atualizando este paciente como senha_atendida igual a um, para que na proxima chamada de senha, ele nao seja novamente comtemplado.


*/
select 	 id 
from 	 painel 
where 	 senha_atendida=0 
order by senha_prioridade desc,
         id asc
limit    1;













