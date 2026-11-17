<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ReadingPlan;
use App\Enums\ReadingPlanStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReadingPlanRequest;
use App\Http\Requests\UpdateReadingPlanRequest;


class ReadingPlanController extends Controller
{
    /**
     * 一覧
     */
    public function index(Request $request)
    {
        $currentStatus = $request->status;

        $readingPlans = ReadingPlan::with('book')
            ->where('user_id', Auth::id())
            ->when(
                $currentStatus,
                fn ($query) => $query->where('status', $currentStatus)
            )
            ->orderBy('target_date')
            ->get();

        
        return view(
            'reading-plans.index',
            compact('readingPlans', 'currentStatus')
        );
}
    /**
     * 新規登録画面
     */
    public function create()
    {
        $books = Book::orderBy('title')->get();

        return view(
            'reading-plans.create',
            compact('books')
        );
    }

    /**
     * 登録
     */
    public function store(StoreReadingPlanRequest $request)
    {
        $validated = $request->validated();

        ReadingPlan::create([
            'user_id' => Auth::id(),
            'book_id' => $validated['book_id'],
            'target_date' => $validated['target_date'],
            'status' => ReadingPlanStatus::Planned,
        ]);

        return redirect()
            ->route('reading-plans.index')
            ->with('success', '読書計画を登録しました。');
    }

    /**
     * 編集画面
     */
    public function edit(ReadingPlan $readingPlan)
    {
        $this->authorizePlan($readingPlan);

        $books = Book::orderBy('title')->get();

        return view(
            'reading-plans.index',
            compact('readingPlan', 'books')
        );
    }

    /**
     * 更新
     */
    public function update(
        UpdateReadingPlanRequest $request,
        ReadingPlan $readingPlan
    ) {
        $this->authorizePlan($readingPlan);

        $validated = $request->validated(); 
        
        $readingPlan->update([
            'status' => ReadingPlanStatus::Completed,
            'completed_at' => now(),
        ]);

        return redirect()
            ->route('reading-plans.index')
            ->with('success', '読書計画を更新しました。');
    }

    /**
     * 削除
     */
    public function destroy(ReadingPlan $readingPlan)
    {
        $this->authorizePlan($readingPlan);

        $readingPlan->delete();

        return redirect()
            ->route('reading-plans.index')
            ->with('success', '読書計画を削除しました。');
    }

    /**
     * 読了
     */
    public function complete(ReadingPlan $readingPlan)
    {
        $this->authorizePlan($readingPlan);

        $readingPlan->update([
            'status' => ReadingPlanStatus::Completed,
            'completed_at' => now(),
        ]);

        return redirect()
            ->route('reading-plans.index')
            ->with('success', '読書完了にしました。');
    }

    /**
     * 自分のデータだけ編集可能
     */
    private function authorizePlan(
        ReadingPlan $readingPlan
    ): void {
        abort_if(
            $readingPlan->user_id !== Auth::id(),
            403
        );
    }
}