<!DOCTYPE html>
<html>

<head>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      font-size: 12px;
    }

    @page {
      margin: 165px 30px 80px 30px;
    }

    header {
      position: fixed;
      top: -129px;
      left: 0;
      right: 0;
      height: 100px;
      /* background-color: #f4f4f4; */
      text-align: center;
      line-height: 1.5;
    }

    footer {
      position: fixed;
      bottom: -60px;
      left: 0;
      right: 0;
      height: 40px;
      background-color: #f4f4f4;
      text-align: center;
      /* line-height: 35px; */
      font-size: 10px;
    }

    .page-number:after {
      content: counter(page);
    }

    /* 
    .content {
      margin-top: 100px;
    } */

    .section-title {
      background-color: #e4e4e4;
      padding: 5px;
      font-weight: bold;
      margin-bottom: 5px;
      margin-top: -5px;
    }

    .info-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .info-table th,
    .info-table td {
      padding: 8px;
      text-align: left;
      border: 1px solid #ddd;
    }

    .info-table th {
      background-color: #f4f4f4;
      font-weight: bold;
    }

    .description {
      white-space: pre-wrap;
      margin-bottom: 20px;
      padding: 0px 5px -3px 5px;
      border: 1px solid #ddd;
    }

    .image-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 10px;
    }

    .image-table td {
      border: 1px solid #ddd !important;
      padding: 8px;
      text-align: center;
    }

    .image-container {
      width: 340px;
      height: 330px;
    }

    .task-container {
      margin-bottom: 10px;
      padding: 5px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    /* Perguntas e respostas */
    .table-questionnaire {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    .table-questionnaire th,
    .table-questionnaire td {
      border: 1px solid #DDD;
      padding: 8px;
      text-align: left;
    }

    .table-questionnaire th {
      background-color: #F4F4F4;
      font-weight: bold;
    }

    .questionario-nome {
      padding: 10px;
      margin-bottom: 25px;
    }

    .questionario-container {
      border: 1px solid #DDD;
      padding: 5px;
    }


    /* .image-container::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      /* A URL da imagem será inserida dinamicamente */
    /*background-repeat: no-repeat;
      background-position: center;
      background-size: cover;
    } */
  </style>
</head>

<body>
  <header>
    <table width="100%">
      <tr style="border: none;">
        <td style="padding-left: 35px; padding-right: 25px; padding-bottom: 12px; width:33% !important;">
          <div style="width: 77%; margin-bottom: 30px"></div>
          <!-- <img src="https://api-gestec.qtsys.com.br:8626/images/loco_pdf_gestec.png" width="77%" alt=""> -->
        </td>
        <td class="text-center" style="width:33% !important; text-align: center !important;">
          <span style="padding-left: 76px; width: 100%; display: inline-block; transform: scale(1.5);">
            <?php $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
            echo $generator->getBarcode($atividade->atividade_id, $generator::TYPE_CODE_128); ?>
          </span>
        </td>
        <td class="text-center" style="width:33% !important; text-align: right !important;">
          <span style="font-family: Verdana, Geneva, Tahoma, sans-serif;">
            {{ date("d/m/Y") }}
          </span>
          <span style="font-family: Verdana, Geneva, Tahoma, sans-serif;" class="page-number text-right">Página: </span>
        </td>
      </tr>
      <tr style="margin-bottom: 10px">
        <td class="border_univ" style="border: 1px solid #ddd; text-align:center; width:30%">
          <img src={{"https://apigestec2.qtsys.com.br/" . $empresa['logomarcar']}} alt="Logo" style="height: 70px; vertical-align: middle;">
        </td>
        <td class="border_univ" style="border: 1px solid #ddd; font-size:18px; text-align:center; width:40%">
          Atividade Técnica
        </td>
        <td class="border_univ" style="border: 1px solid #ddd; font-size:16px; width:30%; text-align: center;">
          <strong><i>{{$atividade->atividade_id }}</i></strong>
        </td>
      </tr>
    </table>
  </header>

  <footer>
    <hr>
    Relatório gerado por Gestec - Sistema de Gestão Técnica - <a target="_blank" href="https://meugestec.com.br/signin">https://meugestec.com.br/</a>
  </footer>

  <div class="content">
    <div class="section-title">Responsabilidade Técnica</div>
    <table class="info-table">
      <tr>
        <th>Responsável</th>
        <th>Documento</th>
        <th>Contato</th>
      </tr>
      <tr>
        <td>{{ $empresa->razao_social }}</td>
        <td>{{ $empresa->cnpj }}</td>
        <td>{{ $empresa->razao_social }} | {{ $empresa->telefone }}</td>
      </tr>
    </table>

    <div class="section-title">Dados da Atividade</div>
    <table class="info-table">
      <tr>
        <th>Título da Atividade</th>
        <td>{{ $atividade->atividade_nome }} - {{$atividade->nome_site}}</td>
      </tr>
      <tr>
        <th>Localização</th>
        <td>{{ $endereco }}</td>
      </tr>
      <tr>
        <th>Previsão</th>
        <td>Início: {{ \Carbon\Carbon::parse($atividade->atividade_created_at)->format('d/m/Y') }} | Entrega: {{ $atividade->finalizado_em ? \Carbon\Carbon::parse($atividade->finalizado_em)->format('d/m/Y') : 'Não definido' }}</td>
      </tr>
    </table>

    <div class="section-title">Descrição da Atividade</div>
    <div class="description">
      {{ $atividade->atividade_descricao }}
    </div>

    @if($atividade->atividade_tipo == "ordem_servico")
    <div class="section-title">Dados do Questionário</div>
    <div class="questionario-container">
      <strong class="questionario-nome">Questionário: {{$questionario->nome}} {{$questionario->descricao}}</strong>
      @foreach($tarefas as $tarefa)
      <div class="task-container">
        <strong> {{$tarefa->nome_tarefa}}</strong>
        <table class="info-table">
          <thead>
            <tr>
              <th>Pergunta</th>
              <th>Resposta</th>
            </tr>
          </thead>
          <tbody>
            @foreach($perguntas_respostas as $pergunta_resposta)
            @if($pergunta_resposta->tarefa_id == $tarefa->tarefa_id)
            <tr>
              <td style="width: 50%">{{$pergunta_resposta->pergunta}}</td>
              <td>{{ $pergunta_resposta->resposta }}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
      @endforeach
    </div>
    @endif



    <div class="section-title">Registro da Atividade</div>
    <table class="image-table">
      @foreach ($anexos as $index => $arquivo)
      @if ($index % 2 == 0)
      <tr>
        @endif
        <td aria-orientation="horizontal">

          <img class="image-container" src="{{'https://apigestec2.qtsys.com.br/' . $arquivo->caminho_arquivo}}" alt="" srcset="">
          <div>{{ $arquivo->descricao }}</div>
        </td>
        @if ($index % 2 != 0 || $index == count($anexos) - 1)
      </tr>
      @endif
      @endforeach
    </table>

    <div class="section-title">Conclusão da Atividade</div>
    <div class="description">
      {{ $atividade->atividade_conclusao }}
    </div>
  </div>
  </div>
</body>

</html>