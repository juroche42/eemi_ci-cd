<?php

namespace App\Entity;

use DateTime;
use ApiPlatform\Metadata\Get;
use Doctrine\DBAL\Types\Types;
use App\ApiFilter\TaskExpirationFilter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TaskRepository;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\Post;
use App\Controller\CreateTaskController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ApiResource(
	operations: [
		new Get(),
		new GetCollection(),
		new Post(
			controller: CreateTaskController::class
		),
	],
	normalizationContext: ['groups' => ['task:read']],
	denormalizationContext: ['groups' => ['task:create']],
)]
#[ApiFilter(SearchFilter::class, properties: ['tags' => 'exact', 'tags.name' => 'exact'])]
#[ApiFilter(TaskExpirationFilter::class)]
class Task
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	#[Groups(['todolist:read:one', 'task:read'])]
	private ?int $id = null;

	#[ORM\Column(length: 255)]
	#[Assert\NotBlank]
	#[Assert\Length(max: 255)]
	#[Groups(['todolist:read:one', 'task:read', 'task:create'])]
	private ?string $title = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	#[Groups(['todolist:read:one', 'task:read', 'task:create'])]
	private ?DateTime $startDate = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	#[Groups(['todolist:read:one', 'task:read', 'task:create'])]
	private ?DateTime $endDate = null;

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	#[Groups(['todolist:read:one', 'task:read', 'task:create'])]
	private ?DateTime $dueDate = null;

	#[ORM\ManyToOne(inversedBy: 'tasks')]
	#[ORM\JoinColumn(nullable: false)]
	#[Assert\NotNull]
	#[Groups(['task:create'])]
	private ?Todolist $todolist = null;

	#[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'tasks', cascade: ["all"])]
	#[Groups(['todolist:read:one', 'task:read', 'task:create'])]
	private Collection $tags;

	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;

		return $this;
	}

	public function getStartDate(): ?DateTime
	{
		return $this->startDate;
	}

	public function setStartDate(?DateTime $startDate): self
	{
		$this->startDate = $startDate;

		return $this;
	}

	public function getEndDate(): ?DateTime
	{
		return $this->endDate;
	}

	public function setEndDate(?DateTime $endDate): self
	{
		$this->endDate = $endDate;

		return $this;
	}

	public function getDueDate(): ?DateTime
	{
		return $this->dueDate;
	}

	public function setDueDate(?DateTime $dueDate): self
	{
		$this->dueDate = $dueDate;

		return $this;
	}

	public function getTodolist(): ?Todolist
	{
		return $this->todolist;
	}

	public function setTodolist(?Todolist $todolist): self
	{
		$this->todolist = $todolist;

		return $this;
	}

	/**
	 * @return Collection<int, Tag>
	 */
	public function getTags(): Collection
	{
		return $this->tags;
	}

	public function addTag(Tag $tag): self
	{
		if (!$this->tags->contains($tag))
		{
			$this->tags->add($tag);
			$tag->addTask($this);
		}

		return $this;
	}

	public function removeTag(Tag $tag): self
	{
		if ($this->tags->removeElement($tag))
			$tag->removeTask($this);

		return $this;
	}
}
