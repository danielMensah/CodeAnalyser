import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CodeComparisonResultComponent } from './code-comparison-result.component';

describe('CodeComparisonResultComponent', () => {
  let component: CodeComparisonResultComponent;
  let fixture: ComponentFixture<CodeComparisonResultComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CodeComparisonResultComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CodeComparisonResultComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
