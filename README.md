# Sistema de Gerenciamento de Reserva de Salas

**Funcionalidades:**

Acesso ao sistema somente autenticado.

Autenticação com as seguintes funcionalidades:
- Login;
- Registro de novos usuários;
- Recuperação de senha.

CRUD de Usuários

CRUD de Salas

Gerenciamento de Reservas, contenplando as seguintes regras:
- Visualização das salas com horários vagos e ocupados;
- Usuário pode efetuar reserva de salas;
- Um usuário não pode resrevar mais de uma sala no mesmo horário;
- Uma sala não pode ser reservada por mais de um usuário no mesmo dia e horário;
- As reservas de salas tem duração de no mínimo 1 hora, ou sejá o usuário pode reservar a sala as 14:00, e ela está "bloqueada" para reserva até o proóximo horário 15:00;
- A edição e exclusão de reservas é possível somente pelo próprio reservante;
- É possível visualizar as reservas por dia, semana ou mês;

_Dump do banco de dados disponível em "dump/init.sql"._

_Disponível uma versão demo em http://reservadesala.herokuapp.com/._