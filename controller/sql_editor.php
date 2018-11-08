<?php
/*
 * This file is part of FacturaSctipts
 * Copyright (C) 2015-2016    Carlos Garcia Gomez         neorazorx@gmail.com
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

    /**
     *
     * @var array
     */
    public $resultados;

    /**
     *
     * @var string
     */
    public $sentencia;

    public function __construct()
    {
        parent::__construct(__CLASS__, 'SQL Editor', 'admin');
    }

    public function columnas_resultado()
    {
        return empty($this->resultados) ? [] : array_keys($this->resultados[0]);
    }

    /**
     * 
     * @param string $sql
     */
    protected function ejecutar($sql)
    {
        if (substr(strtolower($sql), 0, 6) == 'select') {
            $this->resultados = $this->db->select($sql);
            $this->new_message('Secuencia ejecutada.');
        } else if (substr(strtolower($sql), 0, 4) == 'show') {
            $this->resultados = $this->db->select($sql);
            $this->new_message('Secuencia ejecutada.');
        } else if (substr(strtolower($sql), 0, 8) == 'describe') {
            $this->resultados = $this->db->select($sql);
            $this->new_message('Secuencia ejecutada.');
        } elseif ($this->db->exec($sql)) {
            $this->new_message('Secuencia ejecutada correctamente.');
        } else {
            $this->new_error_msg('Error al ejercutar la secuencia.');
        }
    }

    protected function private_core()
    {
        $this->resultados = [];
        $this->sentencia = isset($_POST['sql']) ? $_POST['sql'] : '';

        if (empty($this->sentencia)) {
            return;
        }

        if (!$this->user->admin) {
            $this->new_error_msg('Solamente un administrador puede usar esta página.');
            return;
        }

        $this->ejecutar($this->sentencia);
    }
}
