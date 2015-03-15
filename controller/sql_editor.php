<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sql_editor
 *
 * @author carlos
 */
class sql_editor extends fs_controller
{
   public $resultados;
   public $sentencia;
   
   public function __construct()
   {
      parent::__construct(__CLASS__, 'SQL Editor', 'admin');
   }
   
   protected function private_core()
   {
      $this->resultados = array();
      $this->sentencia = '';
      
      if( isset($_POST['sql']) )
      {
         $this->sentencia = $_POST['sql'];
         
         if($this->sentencia == '')
         {
            
         }
         else if(!$this->user->admin)
         {
            $this->new_error_msg('Solamente un administrador puede usar esta página.');
         }
         else if( substr( strtolower($this->sentencia), 0, 6 ) == 'select' )
         {
            $this->resultados = $this->db->select($this->sentencia);
         }
         else
         {
            if( $this->db->exec($this->sentencia) )
            {
               $this->new_message('Secuencia ejecutada correctamente.');
            }
            else
               $this->new_error_msg('Error al ejercutar la secuencia.');
         }
      }
   }
   
   public function columnas_resultado()
   {
      if($this->resultados)
      {
         return array_keys($this->resultados[0]);
      }
      else
         return array();
   }
}
