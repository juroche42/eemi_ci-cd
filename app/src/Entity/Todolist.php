<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TodolistRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TodolistRepository::class)]
#[ApiResource(operations: [
	new Get(),
])]
class Todolist
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	private ?int $id = null;

	#[ORM\Column(length: 255, unique: true)]
	#[Assert\NotBlank]
	#[Assert\Length(max: 255)]
	private ?string $name = null;

	#[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'todolist', cascade: ["all"], orphanRemoval: true)]
	private Collection $tasks;

	public function __construct()
	{
		$this->tasks = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return Collection<int, Task>
	 */
	public function getTasks(): Collection
	{
		return $this->tasks;
	}

	public function addTask(Task $task): self
	{
		if (!$this->tasks->contains($task))
		{
			$this->tasks->add($task);
			$task->setTodolist($this);
		}

		return $this;
	}

	public function removeTask(Task $task): self
	{
		if ($this->tasks->removeElement($task))
			if ($task->getTodolist() === $this)
				$task->setTodolist(null);

		return $this;
	}
}
