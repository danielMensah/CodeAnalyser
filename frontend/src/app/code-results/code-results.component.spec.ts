import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CodeResultsComponent } from './code-results.component';

describe('CodeResultsComponent', () => {
  let component: CodeResultsComponent;
  let fixture: ComponentFixture<CodeResultsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CodeResultsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CodeResultsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
