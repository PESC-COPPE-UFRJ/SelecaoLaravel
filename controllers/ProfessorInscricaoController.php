<?php

class ProfessorInscricaoController extends \BaseController
{

    /**
     * Lista os candidatos das linhas do perfil (ou todos se for Admin)
     */
    public function getListaCandidatos()
    {

        $tipo = Input::get('tipo');

        if($tipo =='')
        {
            $tipo = 'm';
        }

        if($tipo == 'm')
        {
            $tipoInscricao = 'MSC';
        }
        else
        {
            $tipoInscricao = 'DSC';
        }
        if(Session::has('perfil') && Session::get('perfil') == 1) {
            $areas_usuario = Area::get(); 
        } else {
            $areas_usuario = Auth::user()->areas()->get();
        }
        $areas_usuario = $areas_usuario->lists('nome', 'id');     

        $situacoes = Status::where('ativo','=','1')->orderby('ordem', 'ASC')->lists('descricao', 'id');
        $situacoes_linha = StatusLinha::where('ativo','=','1')->orderby('ordem', 'ASC')->lists('descricao', 'id');
      
        
        $periodos = Periodo::orderBy('ano', 'DESC')->orderBy('periodo', 'DESC')->get();

        //debug($periodos);

        $inscricoes = Inscricao::select('inscricoes.*')->with('usuario','status', 'periodo', 'areas')->join('usuarios', 'inscricoes.usuario_id', '=', 'usuarios.id')->where('curso','=',$tipoInscricao)->orderBy('usuarios.nome','ASC');

        if(Input::has('nome'))
        {
            $nome = Input::get('nome');

            $inscricoes = $inscricoes->whereHas('usuario', function($query) use($nome)
            {
                $query->where('nome', 'LIKE', "%$nome%");
            });
        }
        if(Input::has('periodo_id'))
        {
            $periodo_id = Input::get('periodo_id');
            $inscricoes = $inscricoes->where('periodo_id', '=', $periodo_id);
        }
        else {
            $ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
            $periodo_id = $ultimoPeriodo->id;
            $inscricoes = $inscricoes->where('periodo_id', '=', $periodo_id);
        }
        
        if(Input::has('status_inscricao_id'))
        {            
            $status_inscricao_id = Input::get('status_inscricao_id');
            $inscricoes = $inscricoes->where('status_id', '=', $status_inscricao_id);
        }
        
        if(Input::has('status_linha_id'))
        {            
            $status_linha_id = Input::get('status_linha_id');
            
            // se possui linha selecionada, busca status de linha somente para linha selecionada
            if (Input::has('linha_id'))
            {
                $area_id = Input::get('linha_id');
                $inscricoes = $inscricoes->whereHas('areas', function($query) use($status_linha_id, $area_id)
                {
                 $query->where('areas.id', '=', $area_id)->where('status_id','=', $status_linha_id);                
                });
            }
            else
            {
                $inscricoes = $inscricoes->whereHas('areas', function($query) use($status_linha_id)
                {
                  $query->where('status_id','=', $status_linha_id);                
                });
            }
        }
        
        if (Input::has('solicita_bolsa'))
        {
            $bolsa = Input::get('solicita_bolsa');
            if ($bolsa == 'S')
            {
                $inscricoes = $inscricoes->Where('bolsa', '=', '1');
            }
            else
            {
                $inscricoes = $inscricoes->Where('bolsa', '!=', '1');
            }            
        }
        
        if(Input::has('linha_id'))
        {
            $area_id = Input::get('linha_id');

            $inscricoes = $inscricoes->with(array('areas' => function($query){

            $query->distinct();

            }))->whereHas('areas', function($query) use($area_id)
            {
                $query->where('areas.id', '=', $area_id);
            });
            $inscricoes = $inscricoes->groupBy('usuario_id');
        } 
        elseif(Session::has('perfil') && Session::get('perfil') != 1 && Session::get('perfil') != 6 && Session::get('perfil') != 7)
        {
            $area_id = array();
            if(Session::has('perfil') && Session::get('perfil') == 1) {
                $user_areas = Area::get(); 
            } else {
                $user_areas = Auth::user()->areas;
            }
            foreach($user_areas as $area)
            {
                $area_id[] = $area->id;
            }

            $inscricoes = $inscricoes->whereHas('areas', function($query) use($area_id)
            {
                $query->whereIn('areas.id', $area_id);
            });
        }
        $paginate = (Input::has('pagination')) ? Input::get('pagination') : 10;
        $inscricoes = $inscricoes->paginate($paginate);

        return  View::make('painel_professor.inscricao.candidato_lista', compact('inscricoes', 'areas_usuario', 'situacoes', 'situacoes_linha', 'periodos','periodo_id'));

    }

    public function getCandidaturaHistorico($id)
    {

        if(Input::has('tipo'))
        {
            if(Input::get('tipo') == 'd')
            {
                $status_historico = Usuario::find($id)
                                        ->doutorado
                                        ->status()
                                        ->paginate(10);
            }
            else
            {
                $status_historico = Usuario::find($id)
                                        ->mestrado
                                        ->status()
                                        ->paginate(10);
            }
        }

        $paginate = $status_historico->links();
        $rows = $status_historico->toArray();
        $rows = $rows['data'];

        //debug($rows);

        return View::make('painel_candidato.inscricao.status_candidatura')
                   ->with('rows', $rows)
                   ->with('paginate', $paginate);

    }

    public function getCandidato($id)   {
        //$candidato_id = Input::get('id');

        $candidato = Usuario::with('endereco','formacoes','experiencias','docencias', 'premios')->find($id);
        $poscomps = Poscomp::where('cpf','=',$candidato->cpf)->orWhere('cpf','=',$candidato->id)->orWhere('cpf','=',$candidato->ident)->get();
        return View::make('painel_professor.inscricao.candidato_detalhe', compact('candidato','poscomps'));
    }

    public function getEditarSituacao($id)
    {
            $inscricao = Inscricao::find($id);
            // $formSituacao = DataForm::create();
            $formSituacao = DataForm::create();

            //->rule('required')
            //add fields to the form        
        
            $formSituacao->select('situacao','Situação')->options(Status::where('ativo','=','1')->orderby('ordem', 'ASC')->lists('descricao','id'))->insertValue($inscricao->status_id);
            //$formSituacao->text('cc','CC (opcional)');
            //$formSituacao->select('orientador','Orientador')->options(array(1=>'João',2=>'José'));
            $formSituacao->add('anotacoes','Anotações', 'textarea');
            $formSituacao->hidden('inscricao_id', 'inscricao')->insertValue($id);
            $formSituacao->submit('Enviar Mensagem');
            $formSituacao->build();

            return View::make('painel_professor.inscricao.editar_situacao')->with(compact('formSituacao','inscricao'));

    }

    public function postEditarSituacao()
    {
        extract(Input::all());
        $inscricao = Inscricao::find($inscricao_id);
        $user = $inscricao->usuario;
        $inscricao->status_id = $situacao;
        $inscricao->save();
        $inscricao->status()->attach($situacao, array('anotacoes' => $anotacoes, 'professor_id' => Auth::user()->id));

        if($inscricao->curso == 'DSC')
        {
            $tipo = 'd';
        }
        else
        {
            $tipo = 'm';
        }

        // send email
        
        $messageData = array(
            'nomeProfessor' => Auth::user()->nome,
            'anotacao' => $anotacoes,
            'from_email' => $user->email,
            'from_name' => $user->nome,
            'assunto' => 'Sua situação do PESC foi alterada'
        );

        Mail::send('emails.editar_situacao', $messageData, function ($message) Use ($messageData) {
            $message->from("selecao@cos.ufrj.br", "Selecao");
            $message->bcc("selecao@cos.ufrj.br", "Selecao");
            $message->to($messageData["from_email"],$messageData["from_name"])->subject($messageData["assunto"]);
        });

        $user_id = $inscricao->usuario->id;

        return Redirect::to("professor/inscricao/candidatura-historico/$user_id/?tipo=$tipo")->with('success', array('Status alterado'));

        //$inscricao
    }

    public function getEditarSituacaoLinhaLista($id)
    {
            $inscricao = Inscricao::with('areas')->find($id);

            if(!$inscricao)
            {
                return Redirect::to('panel')->with('warning', ['Inscrição não encontrada']);
            }

            if(Auth::user()->id != $inscricao->usuario_id)
            {
                if(!Session::has('perfil') || Session::get('perfil') != 1)
                {
                    return Redirect::to("panel")->with('danger', array('Acesso negado.'));
                }
            }

            return View::make('painel_professor.inscricao.situacao_linhas_lista', compact('inscricao'));
    }

    public function getEditarSituacaoLinhaSingle($areas_inscricoes_id)
    {
            $areas_inscricoes = AreaInscricao::find($areas_inscricoes_id);

            // $formSituacao = DataForm::create();
            $formSituacao = DataForm::create();

            //->rule('required')
            //add fields to the form

            $formSituacao->select('situacao','Situação')->options(StatusLinha::where('ativo','=','1')->orderby('ordem', 'ASC')->lists('descricao','id'))->insertValue($areas_inscricoes->status_id);
            //$formSituacao->select('situacao','Situação')->options(Status::lists('descricao','id'))->insertValue($areas_inscricoes->status_id);
            //$formSituacao->text('cc','CC (opcional)');
            //$formSituacao->select('orientador','Orientador')->options(array(1=>'João',2=>'José'));
            $formSituacao->add('anotacoes','Anotações', 'textarea')->insertValue($areas_inscricoes->anotacoes);
            $formSituacao->hidden('areas_inscricoes_id', 'inscricao')->insertValue($areas_inscricoes_id);
            $formSituacao->submit('Enviar Mensagem');
            $formSituacao->build();

            return View::make('painel_professor.inscricao.editar_situacao_linha')->with(compact('formSituacao','inscricao'));
    }

    public function postEditarSituacaoLinhaSingle()
    {
        extract(Input::all());
        $areas_inscricoes = AreaInscricao::find($areas_inscricoes_id);
        $user = Inscricao::find($areas_inscricoes->inscricao_id)->usuario;

        $areas_inscricoes->status_id = $situacao;
        $areas_inscricoes->anotacoes = $anotacoes;

        $status_historico = new AreaInscricaoStatusHistorico(['area_inscricao_id' => $areas_inscricoes_id, 'status_id' => $situacao, 'anotacoes' => $anotacoes, 'area_id' => $areas_inscricoes->area_id]);

        $areas_inscricoes->statusHistorico()->save($status_historico);
        $areas_inscricoes->save();

        // send email
        
        $messageData = array(
            'nomeProfessor' => Auth::user()->nome,
            'anotacao' => $anotacoes,
            'from_email' => $user->email,
            'from_name' => $user->nome,
            'assunto' => 'Sua situação do PESC foi alterada'
        );

        Mail::send('emails.editar_situacao', $messageData, function ($message) Use ($messageData) {
            $message->from("selecao@cos.ufrj.br", "Selecao");
            $message->bcc("selecao@cos.ufrj.br", "Selecao");
            $message->to($messageData["from_email"],$messageData["from_name"])->subject($messageData["assunto"]);
        });

        return Redirect::to('professor/inscricao/editar-situacao-linha-lista/' . $areas_inscricoes->inscricao_id)->with('success', array('Status alterado'));

        //$inscricao
    }

    public function getHistoricoStatus($area_inscricao_id)
    {
        $areas_inscricoes = AreaInscricao::find($area_inscricao_id);

        $status_historico = AreaInscricaoStatusHistorico::where('area_inscricao_id', $area_inscricao_id)->where('area_id', $areas_inscricoes->area_id)->paginate(10);

        $area = $areas_inscricoes->area->nome;

        $candidato = $areas_inscricoes->inscricao->usuario;

        $paginate = $status_historico->links();

        return View::make('painel_professor.inscricao.situacao_linha_historico')
                   ->with('rows', $status_historico)
                   ->with('paginate', $paginate)
                   ->with('area_nome', $area)
                   ->with('candidato', $candidato);
    }

        public function getEnviarMensagem()
        {
                //start with empty form to create new Article

                $formMensagem = DataForm::create();

                //->rule('required')
                //add fields to the form

                $formMensagem->text('para','Para');
                $formMensagem->text('cc','CC (opcional)');
                $formMensagem->text('assunto','Assunto');
                $formMensagem->add('teste','teste', 'redactor');
                $formMensagem->submit('Enviar Mensagem');
                $formMensagem->build();

                return View::make('painel_professor.inscricao.enviar_mensagem')->with(compact('formMensagem'));

        }

        public function getProvasNotas()
        {

            $tipo = Input::get('tipo');

            if($tipo =='')
            {
                $tipo = 'm';
            }

            if($tipo == 'm')
            {
                $tipoInscricao = 'MSC';
            }
            else
            {
                $tipoInscricao = 'DSC';
            }

            //->rule('required')
            //add fields to the form
            $formIdentificador = DataForm::create();
            $formIdentificador->select('status.status_id','Situação')->options(Status::lists('descricao','id'));
            $formIdentificador->submit('Gerar Identificador');
            $formIdentificador->build();

            $linhas = Area::all();

            $filterNotas = DataFilter::source(Inscricao::with('usuario','areas','status', 'periodo')->where('curso','=',$tipoInscricao));
            $filterNotas->text('nome','Nome');
            $filterNotas->select('areas.area_id','Linha')->options(Area::lists('nome', 'id'));
            $filterNotas->select('status.status_id','Situação')->options(Status::lists('descricao','id'));
            $filterNotas->submit('Listar');
            $filterNotas->build();

            $status = Status::All();

            return  View::make('painel_professor.inscricao.provas_notas', compact('formIdentificador','filterNotas', 'gridNotas','linhas','status'));
        }

        public function postIdentificador()
        {
            $inputs = Input::all();

            foreach($inputs as $key => $value)
            {
                $$key = $value;
            }

            
            if($tipo != ''){
                $curso         = $tipo == 'm'?'MSC':'DSC';
                $offsetIdProva = $tipo == 'm'?1:501;
            }

            $insIds = array();
            $ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
            $periodo_id = $ultimoPeriodo->id;

            foreach ($status_id as $status) {
                // $inscricoes = Inscricao::where('curso','=',$curso)->get();
                $inscricoes = Inscricao::whereCursoAndStatus_idAndPeriodo_id($curso,$status,$periodo_id)->get();
                // dd($inscricoes);
                foreach($inscricoes as $inscricao)
                {
                    // if($inscricao->status->last()->id == 2) {

                        $inscricao->idProva = $offsetIdProva;
                        $inscricao->save();
                        $offsetIdProva++;
                    // }
                }
            }
            
            return Redirect::to('professor/inscricao/provas-notas?tipo=' . $tipo.'&success=1');

        }

        public function getCapas()
        {
            if(Input::get('curso') == 'm')
                $curso = 'MSC';
            else
                $curso = 'DSC';

            $ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
            $periodo_id = $ultimoPeriodo->id;

            $linha = Area::with(['inscricoes' => function($query) use($periodo_id)
            {
                $query->where('inscricoes.periodo_id','=', $periodo_id);
            }])->find(Input::get('linha'));

            $capa  = Input::get('capa');
            return View::make('painel_professor.inscricao.capas')->with(compact('linha','capa','curso'));
        }

        public function getImprimirCapas()
        {
            $curso = Input::get('curso');
            
            $ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
            $periodo_id = $ultimoPeriodo->id;

            $linha = Area::with(['inscricoes' => function($query) use($periodo_id)
            {
                $query->where('inscricoes.periodo_id','=', $periodo_id);
            }])->find(Input::get('linha'));

            $capa  = Input::get('capa');
            // $html  = View::make('painel_professor.inscricao.capas_impressao')->with(compact('linha','capa'));
            // $pdf = App::make('dompdf');
            // $pdf->loadHTML($html);
            // return $pdf->stream();
            return View::make('painel_professor.inscricao.capas_impressao')->with(compact('linha','capa','curso'));
        }

        public function getPoscomp()
        {

            $tipo = Input::get('tipo');

            if($tipo =='')
            {
                $tipo = 'm';
            }

            if($tipo == 'm')
            {
                $tipoInscricao = 'MSC';
            }
            else
            {
                $tipoInscricao = 'DSC';
            }

            $filterPoscomp = DataFilter::source(Inscricao::with('usuario','status', 'periodo')->with(array('areas' => function($query){
                $query->distinct()->get();
            }))->where('curso','=',$tipoInscricao));
            $filterPoscomp->text('usuario.nome','Nome');
            $filterPoscomp->select('areas.area_id','Linha')->options(Area::lists('nome', 'id'));
            $filterPoscomp->select('status.status_id','Situação')->options(Status::lists('descricao','id'));
            $filterPoscomp->submit('Listar');
            $filterPoscomp->build();

            $gridPoscomp = DataGrid::source($filterPoscomp);
            $gridPoscomp->add('usuario.nome','Nome', true);
            $gridPoscomp->add('periodo.ano','Ano');
            $gridPoscomp->add('periodo.periodo','Periodo');
            $gridPoscomp->add('{{$status->last()->descricao}}','Situação');
            $gridPoscomp->add('curso','Curso');
            $gridPoscomp->add(' @foreach ($areas as $area) {{$area->sigla}} @endforeach ','Linha');
            $gridPoscomp->add('regime','Regime');
            $gridPoscomp->add('bolsa','Bolsa');
            $gridPoscomp->edit('professor/inscricao', '','modify|delete');
            $gridPoscomp->orderBy('id','desc');
            $gridPoscomp->paginate(10);

            $gridPoscomp->row(function ($row) {
                if ($row->cell('bolsa')->value == 0) {
                    $row->cell('bolsa')->value = 'Não';
                }
                else
                {
                    $row->cell('bolsa')->value = 'Sim';
                }
            });

            return View::make('painel_professor.inscricao.poscomp')->with(compact('filterPoscomp','gridPoscomp'));
            //return View::make('painel_professor.inscricao.poscomp');
        }

        public function postPoscomp()
        {
            set_time_limit(0);
            $tipo = Input::get('tipo');

            if($tipo =='')
            {
                $tipo = 'm';
            }

            if($tipo == 'm')
            {
                $tipoInscricao = 'MSC';
            }
            else
            {
                $tipoInscricao = 'DSC';
            }

            if(Input::hasFile('poscomp'))
            {
                $file = Input::file('poscomp');
                $extension = $file->getClientOriginalExtension();
                if($extension == 'xls' || $extension == 'xlsx')
                {
                    //'public\uploads\poscomp_2013.xlsx'
                    $poscompYear = Input::get('poscomp_year');
                    
                    Excel::filter('chunk')->load($file)->chunk(700, function($results) use($poscompYear, $tipo)
                    {
                        $countLinhas = 0;
                                               
                        
                        foreach($results as $row)
                        {
                            
                            
                            // foreach ($rows as $row) {
                                $countLinhas++;
                                $poscomp = new Poscomp;
                                $poscomp->codigo  = $row->codigo;
                            
                                // verifica se inscrição contém apenas digitos, se não remove pontos e hífens
                                $check_insc = $row->inscrcecom;
                                $check_insc = str_replace('.', '', $check_insc);
                                $check_insc = str_replace('-', '', $check_insc);
                               
                                $poscomp->codigo_inscricao  = $check_insc;
                            
                                $poscomp->nome  = $row->nome;
                            
                                // verifica se CPF contém apenas digitos, se não remove pontos e hífens
                                $check_cpf = $row->cpf;
                                $check_cpf = str_replace('.', '', $check_cpf);
                                $check_cpf = str_replace('-', '', $check_cpf);
                                $poscomp->cpf  = $check_cpf;
                                $poscomp->presenca  = ($row->presenca == "PRESENTE" || $row->presenca == "S") ? 1 : 0;
                                $poscomp->pontos  = $row->pontos;
                                $poscomp->tec  = $row->tec;
                                $poscomp->fun  = $row->fun;
                                $poscomp->mat  = $row->mat;
                                $poscomp->local  = $row->local;
                                $poscomp->created_at = Carbon::now()->toDateTimeString();
                                $poscomp->ano = $poscompYear;

                                
                            
                                $resposta_questoes = null;
                                if($poscomp->presenca){
                                    $contadorQuestoes = 0;
                                    $questoes = true;
                                    $arrQuestion = array();
                                    while($questoes){
                                        if(isset($row[$contadorQuestoes])){
                                            $questionAnswer = $row[$contadorQuestoes];
                                            $contadorQuestoes++;
                                            $QuestionNumber = $contadorQuestoes;
                                            $arrQuestion[$QuestionNumber] = $questionAnswer;
                                        } else {
                                            $questoes = false;
                                        }
                                    }

                                    $resposta_questoes = json_encode($arrQuestion);
                                }


                                $poscomp->resposta_questoes = $resposta_questoes;
                                
                            
                                $poscomp->save();
                            // }
                        }
                    });

                    return Redirect::to('professor/inscricao/poscomp?tipo=' . $tipo)->with('success',array(1 => 'Poscomp importado com sucesso!'));
                }
                else
                {
                    return Redirect::to('professor/inscricao/poscomp?tipo=' . $tipo)->with('danger',array(1 => 'O arquivo enviado não é válido, precisa ser um xls ou xlsx!'));
                }
            } else {
                return Redirect::to('professor/inscricao/poscomp?tipo=' . $tipo)->with('danger',array(1 => 'Nenhum arquivo enviado!'));
            }
        }

        public function getPoscompDetalhe()
        {
                $id      = Input::get('show');
                $usuario = Usuario::find($id);
                return View::make('painel_professor.inscricao.poscomp_detalhe')->with(compact('usuario'));
        }

        public function getShow()
        {
            $id = Input::get('show');
            //start with empty form to create new Article

            $formSituacao = DataForm::create();

            //->rule('required')
            //add fields to the form

            $formSituacao->select('situacao','Situação')->options(Status::lists('descricao','id'));
            $formSituacao->text('cc','CC (opcional)');
            $formSituacao->select('orientador','Orientador')->options(array(1=>'João',2=>'José'));
            $formSituacao->add('anotacoes','Anotações', 'textarea');
            $formSituacao->submit('Enviar Mensagem');
            $formSituacao->build();

            return View::make('painel_professor.inscricao.editar_situacao')->with(compact('formSituacao'));
        }

    public function getDadosCsv()
    {
        //$candidato = Usuario::with('formacoes')->find(Auth::user()->id);

        $id = Input::get('id');

        $candidato = Usuario::with('formacoes','experiencias')->find($id);

        $export = Excel::create("$candidato->id-$candidato->nome", function($excel) use($candidato) {

            $excel->sheet('Sheetname', function($sheet) use($candidato) {

                //$candidato = Usuario::find(Auth::user()->id);
                //$sheet->fromArray($candidato->toArray());

                // $sheet->fromArray(array(array('data1', 'data2'),
                               //          array('data3', 'data4')));

                
                $sheet->loadView('painel_candidato.inscricao.csv', array('candidato' => $candidato));

            });

        })->export('csv');

        return $export;
    }

    public function getDadosPdf()
    {

        extract(Input::all());

        $periodo   = Periodo::where('status','>=','0')->orderBy('created_at', 'desc')->first();       

        $candidato = Usuario::with('endereco','formacoes','experiencias','docencias','inscricoes')->find($id);

        $pdf = PDF::loadView('painel_professor.inscricao.pdf', compact('periodo', 'candidato'));

        return $pdf->download("$candidato->id-$candidato->nome.pdf");

    }
  
    public function getDadosRMPdf()
    {

        extract(Input::all());

        $periodo   = Periodo::where('status','>=','0')->orderBy('created_at', 'desc')->first();       

        $candidato = Usuario::with('endereco','formacoes','experiencias','docencias','inscricoes')->find($id);

        $pdf = PDF::loadView('painel_professor.inscricao.RMpdf', compact('periodo', 'candidato'));

        return $pdf->download("$candidato->nome-RM.pdf");

    }

    public function getCheckIdentficador()
    {
        $situacao = Input::get('situacao');
        $tipo = Input::get('tipo');
        if($tipo == 'm') { $tipoInscricao = 'MSC'; } else { $tipoInscricao = 'DSC'; }
        $ultimoPeriodo = Periodo::where('status','<>',0)->orderBy('id', 'DESC')->first();
        $periodo_id = $ultimoPeriodo->id;

        $inscricoes = Inscricao::where('curso','=',$tipoInscricao)->whereIn('status_id',$situacao)->where('periodo_id','=',$periodo_id)->where('idprova','>','0')->first();
        if(count($inscricoes) > 0){
            return 1;
        }
        return 0;
    }

    public function getIndex(){
        if(Input::has('show')){
            $id = Input::get('show');
            $inscricao = Inscricao::find($id);

            
            return Redirect::to("professor/inscricao/candidato/".$inscricao->usuario_id);
        } elseif(Input::has('modify')){

            $id = Input::get('modify');
            // $this->getEditarSituacao($inscricao);

            // $inscricao = Inscricao::find($id);
            return Redirect::to("professor/inscricao/editar-situacao/".$id);
        } elseif(Input::has('delete')){
            $id = Input::get('delete');
            dd('delete');
        }
    }

}
