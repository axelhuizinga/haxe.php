<?php
/**
 * Generated by Haxe 4.1.1
 */

namespace haxe\ds;

use \php\_Boot\HxAnon;
use \php\Boot;

/**
 * A stack of elements.
 * This class is generic, which means one type is generated for each type
 * parameter T on static targets. For example:
 * - `new GenericStack<Int>()` generates `GenericStack_Int`
 * - `new GenericStack<String>()` generates `GenericStack_String`
 * The generated name is an implementation detail and should not be relied
 * upon.
 * @see https://haxe.org/manual/std-GenericStack.html
 */
class GenericStack {
	/**
	 * @var GenericCell
	 */
	public $head;

	/**
	 * Creates a new empty GenericStack.
	 * 
	 * @return void
	 */
	public function __construct () {
	}

	/**
	 * Pushes element `item` onto the stack.
	 * 
	 * @param mixed $item
	 * 
	 * @return void
	 */
	public function add ($item) {
		$this->head = new GenericCell($item, $this->head);
	}

	/**
	 * Returns the topmost stack element without removing it.
	 * If the stack is empty, null is returned.
	 * 
	 * @return mixed
	 */
	public function first () {
		if ($this->head === null) {
			return null;
		} else {
			return $this->head->elt;
		}
	}

	/**
	 * Tells if the stack is empty.
	 * 
	 * @return bool
	 */
	public function isEmpty () {
		return $this->head === null;
	}

	/**
	 * Returns an iterator over the elements of `this` GenericStack.
	 * 
	 * @return object
	 */
	public function iterator () {
		$l = $this->head;
		return new HxAnon([
			"hasNext" => function () use (&$l) {
				return $l !== null;
			},
			"next" => function () use (&$l) {
				$k = $l;
				$l = $k->next;
				return $k->elt;
			},
		]);
	}

	/**
	 * Returns the topmost stack element and removes it.
	 * If the stack is empty, null is returned.
	 * 
	 * @return mixed
	 */
	public function pop () {
		$k = $this->head;
		if ($k === null) {
			return null;
		} else {
			$this->head = $k->next;
			return $k->elt;
		}
	}

	/**
	 * Removes the first element which is equal to `v` according to the `==`
	 * operator.
	 * This method traverses the stack until it finds a matching element and
	 * unlinks it, returning true.
	 * If no matching element is found, false is returned.
	 * 
	 * @param mixed $v
	 * 
	 * @return bool
	 */
	public function remove ($v) {
		$prev = null;
		$l = $this->head;
		while ($l !== null) {
			if (Boot::equal($l->elt, $v)) {
				if ($prev === null) {
					$this->head = $l->next;
				} else {
					$prev->next = $l->next;
				}
				break;
			}
			$prev = $l;
			$l = $l->next;
		}
		return $l !== null;
	}

	/**
	 * Returns a String representation of `this` GenericStack.
	 * 
	 * @return string
	 */
	public function toString () {
		$a = new \Array_hx();
		$l = $this->head;
		while ($l !== null) {
			$a->arr[$a->length++] = $l->elt;
			$l = $l->next;
		}
		return "{" . ($a->join(",")??'null') . "}";
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(GenericStack::class, 'haxe.ds.GenericStack');