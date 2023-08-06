<?php

namespace Laravel\Nova\Fields;

use Laravel\Nova\Element;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class FieldElement extends Element
{
    /**
     * The field's assigned panel.
     *
     * @var string|null
     */
    public $panel;

    /**
     * The field's assigned panel.
     *
     * @var \Laravel\Nova\Panel|null
     */
    public $assignedPanel;

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var (callable():bool)|bool
     */
    public $showOnIndex = true;

    /**
     * Indicates if the element should be shown on the detail view.
     *
     * @var (callable():bool)|bool
     */
    public $showOnDetail = true;

    /**
     * Indicates if the element should be shown on the creation view.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest):bool)|bool
     */
    public $showOnCreation = true;

    /**
     * Indicates if the element should be shown on the update view.
     *
     * @var (callable(\Laravel\Nova\Http\Requests\NovaRequest, mixed):bool)|bool
     */
    public $showOnUpdate = true;

    /**
     * Specify that the element should be hidden from the index view.
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this
     */
    public function hideFromIndex($callback = true)
    {
        $this->showOnIndex = is_callable($callback) ? function () use ($callback) {
            return ! call_user_func_array($callback, func_get_args());
        }
        : ! $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the detail view.
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this
     */
    public function hideFromDetail($callback = true)
    {
        $this->showOnDetail = is_callable($callback) ? function () use ($callback) {
            return ! call_user_func_array($callback, func_get_args());
        }
        : ! $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the creation view.
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this
     */
    public function hideWhenCreating($callback = true)
    {
        $this->showOnCreation = is_callable($callback) ? function () use ($callback) {
            return ! call_user_func_array($callback, func_get_args());
        }
        : ! $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the update view.
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this
     */
    public function hideWhenUpdating($callback = true)
    {
        $this->showOnUpdate = is_callable($callback) ? function () use ($callback) {
            return ! call_user_func_array($callback, func_get_args());
        }
        : ! $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the index view.
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this
     */
    public function showOnIndex($callback = true)
    {
        $this->showOnIndex = $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the detail view.
     *
     * @param  (callable():bool)|bool  $callback
     * @return $this
     */
    public function showOnDetail($callback = true)
    {
        $this->showOnDetail = $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the creation view.
     *
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest):bool)|bool  $callback
     * @return $this
     */
    public function showOnCreating($callback = true)
    {
        $this->showOnCreation = $callback;

        return $this;
    }

    /**
     * Specify that the element should be hidden from the update view.
     *
     * @param  (callable(\Laravel\Nova\Http\Requests\NovaRequest, mixed):bool)|bool  $callback
     * @return $this
     */
    public function showOnUpdating($callback = true)
    {
        $this->showOnUpdate = $callback;

        return $this;
    }

    /**
     * Check for showing when updating.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return bool
     */
    public function isShownOnUpdate(NovaRequest $request, $resource): bool
    {
        if (is_callable($this->showOnUpdate)) {
            $this->showOnUpdate = call_user_func($this->showOnUpdate, $request, $resource);
        }

        return $this->showOnUpdate;
    }

    /**
     * Check showing on index.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return bool
     */
    public function isShownOnIndex(NovaRequest $request, $resource): bool
    {
        if (is_callable($this->showOnIndex)) {
            $this->showOnIndex = call_user_func($this->showOnIndex, $request, $resource);
        }

        return $this->showOnIndex;
    }

    /**
     * Determine if the field is to be shown on the detail view.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return bool
     */
    public function isShownOnDetail(NovaRequest $request, $resource): bool
    {
        if (is_callable($this->showOnDetail)) {
            $this->showOnDetail = call_user_func($this->showOnDetail, $request, $resource);
        }

        return $this->showOnDetail;
    }

    /**
     * Determine if the field is to be shown in the preview modal.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  mixed  $resource
     * @return bool
     */
    public function isShownOnPreview(NovaRequest $request, $resource): bool
    {
        return $this->showOnPreview;
    }

    /**
     * Check for showing when creating.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return bool
     */
    public function isShownOnCreation(NovaRequest $request): bool
    {
        if (is_callable($this->showOnCreation)) {
            $this->showOnCreation = call_user_func($this->showOnCreation, $request);
        }

        return $this->showOnCreation;
    }

    /**
     * Specify that the element should only be shown on the index view.
     *
     * @return $this
     */
    public function onlyOnIndex()
    {
        $this->showOnIndex = true;
        $this->showOnDetail = false;
        $this->showOnCreation = false;
        $this->showOnUpdate = false;

        return $this;
    }

    /**
     * Specify that the element should only be shown on the detail view.
     *
     * @return $this
     */
    public function onlyOnDetail()
    {
        parent::onlyOnDetail();

        $this->showOnIndex = false;
        $this->showOnDetail = true;
        $this->showOnCreation = false;
        $this->showOnUpdate = false;

        return $this;
    }

    /**
     * Specify that the element should only be shown on forms.
     *
     * @return $this
     */
    public function onlyOnForms()
    {
        $this->showOnIndex = false;
        $this->showOnDetail = false;
        $this->showOnCreation = true;
        $this->showOnUpdate = true;

        return $this;
    }

    /**
     * Specify that the element should be hidden from forms.
     *
     * @return $this
     */
    public function exceptOnForms()
    {
        $this->showOnIndex = true;
        $this->showOnDetail = true;
        $this->showOnCreation = false;
        $this->showOnUpdate = false;

        return $this;
    }

    /**
     * Prepare the field element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            'panel' => $this->panel,
        ]);
    }
}
