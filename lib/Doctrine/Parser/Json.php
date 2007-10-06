<?php
/*
 *  $Id: Json.php 1080 2007-02-10 18:17:08Z jwage $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.phpdoctrine.com>.
 */
/**
 * Doctrine_Parser_Json
 *
 * @package     Doctrine
 * @subpackage  Parser
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link        www.phpdoctrine.com
 * @since       1.0
 * @version     $Revision: 1080 $
 * @author      Jonathan H. Wage <jwage@mac.com>
 */
class Doctrine_Parser_Json extends Doctrine_Parser
{
    /**
     * dumpData
     *
     * Dump an array of data to a specified path or return
     * 
     * @param string $array 
     * @param string $path 
     * @return void
     * @author Jonathan H. Wage
     */
    public function dumpData($array, $path = null)
    {
        $data = json_encode($array);
        
        if ($path) {
            return file_put_contents($path, $data);
        } else {
            return $data;
        }
    }
    /**
     * loadData
     *
     * Load and unserialize data from a file or from passed data
     * 
     * @param string $path 
     * @return void
     * @author Jonathan H. Wage
     */
    public function loadData($path)
    {
        if (file_exists($path) && is_readable($path)) {
            $data = file_get_contents($path);
        } else {
            $data = $path;
        }
        
        $json = json_decode($data);
        
        return $this->prepareData($json);
    }
    
    public function prepareData($json)
    {
        $array = array();
        
        foreach ($json as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $array[$key] = $this->prepareData($value);
            } else {
                $array[$key] = $value;
            }
        }
        
        return $array;
    }
}