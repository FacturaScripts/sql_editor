<?php

/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2015    Carlos Garcia Gomez         neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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
            $this->new_message('Secuencia ejecutada.');
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
